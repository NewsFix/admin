<?php
session_start();

require_once('battle/text.php');
require_once('battle/saveData.php');
require_once('battle/poison_status.php');
require_once('battle/paralysis_status.php');



// 戦闘テキストを管理するClass
use Battle\Text;
// データセーブを管理するClass
use Battle\SaveData;
// 毒異常を管理するClass
use Battle\Poison;
// 麻痺異常を管理するClass
use Battle\Paralysis;

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
        //setcookie("paralysis", true, time()-60*60);
        //error_log(var_export($_COOKIE, true));

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

        /**
         * 文字化け状態異常を生成
         *
         *
         */


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

        // Paralysisクラスは毎回インスタンス化されるけど一旦これで

        $paralysis = new Battle\Paralysis();
        $char = $paralysis->updateParalysisStatus($char_name, $char, $skills, $use_skill_id, $save);

        //COOKIE,SESSIONいずれも挿入する情報は必要最低限にする。HP,MP意外戦闘で不必要な情報は不要。
        if (!isset($_COOKIE[$char_name. '_hp'])) {
            // hpがない場合生成
            $save->cookie($char_name. '_hp', $char->hp);
        } else {
            $char->hp = $_COOKIE[$char_name. '_hp'];

            //麻痺攻撃を受けたもしくは麻痺継続の場合は攻撃等できない
            if ($char->paralysis == false) {

                //すでにHPがある場合は戦闘の減産処理を行う
                $damage = $skills[$use_skill_id]["damage"];

                //$hpに代入してしまうと、updatePoisonStatusメソッドへHPを継承できないため、毒異常減算のみが上書きされてしまう。
                $char->hp -= $damage;

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

                // poison_statusクラスは毎回インスタンス化されるけど一旦これで
                $poison_status = new Battle\Poison();

                $char = $poison_status->updatePoisonStatus($char_name, $char, $skills, $use_skill_id, $save);

                $hp = $char->hp;


                // キャラクターオブジェクトのHPを更新
                /* updatePoisonStatus内でHP減算処理済みのため、
                こちらの処理は不要。今後必要なければ削除 */
                $char->setHp($hp);

                // キャラクターのHPをcookieにセット
                $save->cookie($char_name. '_hp', $hp);
            }
        }
        // 更新済みObjectを返す
        return $char;
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
}
