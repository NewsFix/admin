<?php
session_start();

require_once('battle/text.php');
require_once('battle/saveData.php');

// 戦闘テキストを管理するClass
use Battle\Text;
// データセーブを管理するClass
use Battle\SaveData;

class Command
{
    /**
     * 主人公と敵側のHP,MPの加算減算処理
     * 現在、主人公はCOOKIE側、敵側は SESSIONで保持して計算
     * PHP練習目的のため不統一だが、最終的に統一予定。
     *
     * POST形式、FORM送信後のデータ受け取りをトリガーに戦闘コメ* ントを配列にしgate_way.phpに渡す。その後jsonエンコード* 処理を経てbattle.phpでJSを用いてコメント内容を使用
     *
     * @param object $player
     * @param object $pinoko
     * @return array 敵味方コメントとHP
     */
    public function get($player, $pinoko)
    {

        //使用するスキルは乱数発生
        $player_use_skill_id = rand(3, count($player->skills)-1);
        $pinoko_use_skill_id = rand(0, count($pinoko->skills)-5);

        // Objectの更新とcokkieセット
        $player = $this->updateCharStatus('player', $player, $pinoko->skills, $pinoko_use_skill_id);
        $pinoko = $this->updateCharStatus('pinoko', $pinoko, $player->skills, $player_use_skill_id);

        // attackがない場合は初回である
        $is_first = !isset($_REQUEST["attack"]) ? true: false;
        // 戦闘表示テキストの取得
        $strike_text = $this->getStrikeTexts($player, $pinoko, $player_use_skill_id, $pinoko_use_skill_id, $is_first);

        //取得した戦闘コメント、更新された各オブジェクトのHPプロパティを配列化して返す。呼び出しはgate_way.phpより行う。
        return array(
            "strike_text" => $strike_text['player'],
            "enemy_strike_text" => $strike_text['enemy'],
            "pinoko" => $pinoko->getStatus(), // キャラクターのステータスを取得
            "player" => $player->getStatus(), // キャラクターのステータスを取得,
            //"player_hp" => "HP:".$player->hp,
            "array_detail" => null // TODO: 使われて無さそう
        );
    }

    /**
     * 毒化した場合のダメージ幅設定
     * ※後に切り分けるため移動すること
     *
     * @param int $min 最低値
     * @param int $min 最高値
     * @return
     */
    private function poisonLogic($min, $max):int
    {
        return rand($min, $max);
    }

    /**
     * キャラクター情報の更新を行う
     * @param String $char_name    キャラクター名(player, pinokoなどのほう外部入力されたものではない)
     * @param Object $char         キャラクターClass Object
     * @param Array  $skills       使用されるスキル群
     * @param Int    $use_skill_id 使用されるスキルID
     * @return Object 更新したキャラクター
     */
    private function updateCharStatus(String $char_name, object $char, array $skills, Int $use_skill_id)
    {
        // SaveDataクラスは毎回インスタンス化されるけど一旦これで
        $save = new Battle\SaveData();
        //COOKIE,SESSIONいずれも挿入する情報は必要最低限にする。HP,MP意外戦闘で不必要な情報は不要。
        if (!isset($_COOKIE[$char_name. '_hp'])) {
            // hpがない場合生成
            $save->cookie($char_name. '_hp', $char->hp);
        } else {
            //すでにHPがある場合は戦闘の減産処理を行う
            $char->hp = $_COOKIE[$char_name. '_hp'];
            $damage = $skills[$use_skill_id]["damage"];
            $hp = $char->hp - $damage;

            // キャラクタが即死したかどうかをセットする
            $char->setDeath($skills[$use_skill_id]["death"]);

            // HP 0以下ならキャラクターの死亡状態にtrue（死亡）をセット
            if (0 >= $hp && false) { //TODO: たぶんcookieにHPマイナスで入ってるからfalseにしておく
                $char->setDeath(true);
            }

            // 死んでいたらHPを0にセット
            if ($char->skills[$use_skill_id]["death"]) {
                $hp = 0;
            }

            /**
             *
             * 0.前提条件として毒状態かどうか確認し、毒状態でなければ1を実行
             * 1.毒攻撃による確率計算を行い、true or falseの審査
             * 2.trueの場合はCOOKIEにpoison=trueをセットする
             * 3.COOKIEにすでに値が入っている場合は毒解除計算を行い、毒解除に成功していればpoison=falseをセット
             * 4.毒解除がfalseの場合は毒ダメージ計算処理を行う
             */

            //$_COOKIE[$char_name."_poison"]がCOOKIE配列に入っていない場合
            if (!isset($_COOKIE[$char_name."_poison"])) {
                $char = $this->setPoison($char_name, $save, $char, $skills[$use_skill_id]["poison"]);

                //毒の時の処理
                //上記の理由からCOOKIEは、まだ更新されていないためCOOKIEを参考にしない
                if ($char->poison) {
                    $hp -= $this->poisonLogic(10000, 20000);
                }
            } else {
                //毒継続かの判断のためCOOKIEに入っている既存値を参照し、かつ毒であった場合
                $isPoison = $_COOKIE[$char_name."_poison"] == "1"? true: false; //別に三項演算である必要はない

                if ($isPoison) { // キャラクターが毒であるとき
                    // 毒のリフレッシュ処理を行う
                    if ($this->refreshPoison()) {
                        // 毒のリフレッシュ(治った)とき, キャラを毒falseにする
                        $char = $this->setPoison($char_name, $save, $char, false);
                    } // 毒解除失敗時はなにもしない

                    // キャラクターが毒であればHP減算
                    if ($char->poison) {
                        $hp -= $this->poisonLogic(10000, 20000);
                    }
                } else { // キャラクターが毒ではないとき
                    $char = $this->setPoison($char_name, $save, $char, $skills[$use_skill_id]["poison"]);
                }
            }

            // キャラクターオブジェクトのHPを更新
            $char->setHp($hp);
            // キャラクターのHPをcookieにセット
            $save->cookie($char_name. '_hp', $hp);
        }
        // 更新済みObjectを返す
        return $char;
    }

    /**
     * 毒情報を保存する
     *
     * @param Object $save
     * @param Object $char
     * @param 毒か否か
     * @return Object Char class
     */
    private function setPoison(String $char_name, Object $save, Object $char, Bool $isPoison): Object
    {
        error_log($isPoison ?"毒になった": "スキルは毒攻撃ではなかったもしくは毒にならなかった");
        //毒化計算を終えたtrueもしくはfalseをプロパティにセットする
        $char->setPoison($isPoison);
        //上記のプロパティ結果をCOOKIEにセットする
        //注意: setcookieのセットタイミングは2周目以降に適応
        $save->cookie($char_name. "_poison", $isPoison? "1": "0");

        return $char;

    }

    /**
     * 毒解除処理を行う
     *
     * @return boolean 毒解除成功 true
     */
    private function refreshPoison(): Bool
    {
        // 1/2で毒解除処理
        if (50 > rand(0, 100)) {
            error_log("毒が解除された");
            return true;
        }
        // 毒解除できないとき
        error_log("毒の解除に失敗した");
        return false;
    }

    /**
     * 戦闘テキストをまとめて取得するロジック
     *
     * @param Object $player Player class
     * @param Object $enemy Enemy class
     * @return Array playerとenemyの戦闘テキスト
     */
    private function getStrikeTexts($player, $enemy, $player_use_skill_id, $enemy_use_skill_id, $is_first)
    {
        $textGenerator = new Battle\Text();

        $player_text = '';
        $enemy_text = '';

        // 初回ターンは敵との遭遇テキスト
        if ($is_first) {
            $player_text = "$enemy->name がおそいかかってきた!!!";
        } else {
            $player_text = $textGenerator->attackText($player->name, $player->skills[$player_use_skill_id]['name'], $player->skills[$player_use_skill_id]['text'], $enemy->name, $player->skills[$player_use_skill_id]['damage']);
            $enemy_text = $textGenerator->attackText($enemy->name, $enemy->skills[$enemy_use_skill_id]['name'], $enemy->skills[$enemy_use_skill_id]['text'], $player->name, $enemy->skills[$enemy_use_skill_id]['damage']);
        }

        return array(
            'player' => $player_text,
            'enemy' => $enemy_text,
        );
    }

    //配列へスキルごとに即死率を入れているので不必要
    /*
    private function checkDeath(Bool $skillDeath, $rate = 2): bool
    {
        // trueが来ても即死させない、10分の1で死ぬ確率
        $probability = rand(1, 2);
        // 即死技かつランダム値が10のときはtrueを返す
        if ($skillDeath && $rate === $probability) {
            return true;
        }

        return false;
    }
    */
}
