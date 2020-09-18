<?php
namespace Battle;

class EncodeBug
{
    private const ENCODE_BUG = "_encode_bug";

    /**
     * エンコード状態異常化の仕組みのパッケージ
     *
     * @param String $char_name キャラ名
     * @param Object $char キャラのオブジェクト
     * @param Array  $skills 使用されるスキル群
     * @param Int    $use_skill_id 使用されるスキル
     * @param Object $save COOKIE更新用オブジェクト
     * @return object エンコード状態異常の計算結果を反映した$charオブジェクト
     */

    public function updateEncodeBugStatus(String $char_name, object $char, array $skills, Int $use_skill_id, object $save)
    {
        //$_COOKIE[$char_name.self::ENCODE_BUG]がCOOKIE配列に入っていない場合
        if (!isset($_COOKIE[$char_name.self::ENCODE_BUG])) {
            $char = $this->setEncodeBug($char_name, $save, $char, $skills[$use_skill_id]["encode_bug"]);
        } else {
            error_log("elseにきてるよ！！");
            //エンコード状態異常継続かの判断のためCOOKIEに入っている既存値を参照し、かつエンコード状態異常であった場合
            $is_encode_bug = $_COOKIE[$char_name.self::ENCODE_BUG] == "1";
            //別に三項演算である必要はない

            //$isPoisonに直接intの1を入力した場合はなぜか動かない。php -a 試した結果trueになっていた
            if ($is_encode_bug) {
                // キャラクターがエンコード状態異常であるとき
                // エンコード状態異常のリフレッシュ処理を行う
                if ($this->refreshEncodeBug()) {
                    // エンコード状態異常のリフレッシュ(治った)とき, キャラをエンコード状態異常falseにする

                    $char = $this->setEncodeBug($char_name, $save, $char, false);
                }
            } else { // キャラクターがエンコード状態異常ではないとき
                $char = $this->setEncodeBug($char_name, $save, $char, $skills[$use_skill_id]["encode_bug"]);
            }
        }
        return $char;
    }


    /**
    * エンコード状態異常情報を保存する
    *
    * @param String $char_name
    * @param Object $save
    * @param Object $char
    * @param Boolean $is_encode_bug
    * @return Object Char class
    */
    private function setEncodeBug(String $char_name, Object $save, Object $char, Bool $is_encode_bug): Object
    {
        //error_log($is_encode_bug ?"エンコード状態異常になった": "スキルはエンコード状態異常攻撃ではなかったもしくはエンコード状態異常にならなかった");

        //エンコード状態異常化計算を終えたtrueもしくはfalseをプロパティにセットする
        $char->setEncodeBug($is_encode_bug);

        //上記のプロパティ結果をCOOKIEにセットする
        //注意: setcookieのセットタイミングは2周目以降に適応

        $save->cookie($char_name.self::ENCODE_BUG, $is_encode_bug ? "1": "0");

        return $char;
    }

    /**
     * エンコード状態異常解除処理を行う
     *
     * @return boolean エンコード状態異常解除成功 true
     */
    private function refreshEncodeBug(): Bool
    {
        // 1/2でエンコード状態異常解除処理
        if (50 > rand(0, 100)) {
            //error_log("エンコード状態異常が解除された");
            return true;
        }
        // エンコード状態異常解除できないとき
        //error_log("エンコード状態異常の解除に失敗した");
        return false;
    }
}
