<?php
namespace Battle;

class Poison
{
    /**
    *
    * 0.前提条件として毒状態かどうか確認し、毒状態でなければ1を実行
    * 1.毒攻撃による確率計算を行い、true or falseの審査
    * 2.trueの場合はCOOKIEにpoison=trueをセットする
    * 3.COOKIEにすでに値が入っている場合は毒解除計算を行い、毒解除に成功していればpoison=falseをセット
    * 4.毒解除がfalseの場合は毒ダメージ計算処理を行う
    */

    /**
     * 毒化の仕組みのパッケージ
     *
     * @param String $char_name キャラ名
     * @param Object $char キャラのオブジェクト
     * @param Array  $skills 使用されるスキル群
     * @param Int    $use_skill_id 使用されるスキル
     * @param Object $save COOKIE更新用オブジェクト
     * @return object 毒状態異常の計算結果を反映した$charオブジェクト
     */

    public function updatePoisonStatus(String $char_name, object $char, array $skills, Int $use_skill_id, object $save)
    {

        //$_COOKIE[$char_name."_poison"]がCOOKIE配列に入っていない場合
        if (!isset($_COOKIE[$char_name."_poison"])) {
            error_log($char_name);

            $char = $this->setPoison($char_name, $save, $char, $skills[$use_skill_id]["poison"]);

            //毒の時の処理
            //上記の理由からCOOKIEは、まだ更新されていないためCOOKIEを参考にしない
            if ($char->poison) {
                $char->hp -= $this->poisonLogic(10000, 20000);
            }
        } else {
            //毒継続かの判断のためCOOKIEに入っている既存値を参照し、かつ毒であった場合
            $isPoison = $_COOKIE[$char_name."_poison"] == "1";
            //別に三項演算である必要はない

            //$isPoisonに直接intの1を入力した場合はなぜか動かない。php -a 試した結果trueになっていた
            if ($isPoison) {
                // キャラクターが毒であるとき
                // 毒のリフレッシュ処理を行う
                if ($this->refreshPoison()) {
                    // 毒のリフレッシュ(治った)とき, キャラを毒falseにする
                    error_log($char_name);


                    $char = $this->setPoison($char_name, $save, $char, false);
                } // 毒解除失敗時はなにもしない

                // キャラクターが毒であればHP減算
                if ($char->poison) {
                    $char->hp -= $this->poisonLogic(10000, 20000);
                }
            } else { // キャラクターが毒ではないとき

                error_log($char_name);

                $char = $this->setPoison($char_name, $save, $char, $skills[$use_skill_id]["poison"]);

                if ($char->poison) {
                    $char->hp -= $this->poisonLogic(10000, 20000);
                }
            }
        }
        return $char;
    }


    /**
    * 毒情報を保存する
    *
    * @param String $char_name
    * @param Object $save
    * @param Object $char
    * @param Boolean $isPoison
    * @return Object Char class
    */
    private function setPoison(String $char_name, Object $save, Object $char, Bool $isPoison): Object
    {
        error_log($isPoison ?"毒になった": "スキルは毒攻撃ではなかったもしくは毒にならなかった");

        //毒化計算を終えたtrueもしくはfalseをプロパティにセットする
        $char->setPoison($isPoison);

        //上記のプロパティ結果をCOOKIEにセットする
        //注意: setcookieのセットタイミングは2周目以降に適応
        error_log($char_name);
        $save->cookie($char_name. "_poison", $isPoison ? "1": "0");

        return $char;
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
}
