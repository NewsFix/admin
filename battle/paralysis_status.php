<?php
namespace Battle;

class Paralysis
{

    /**
     * 麻痺化の仕組みのパッケージ
     *
     * @param String $char_name キャラ名
     * @param Object $char キャラのオブジェクト
     * @param Array  $skills 使用されるスキル群
     * @param Int    $use_skill_id 使用されるスキル
     * @param Object $save COOKIE更新用オブジェクト
     * @return object 麻痺状態異常の計算結果を反映した$charオブジェクト
     */

    public function updateParalysisStatus(String $char_name, object $char, array $skills, Int $use_skill_id, object $save)
    {

        //$_COOKIE[$char_name."_paralysis"]がCOOKIE配列に入っていない場合
        if (!isset($_COOKIE[$char_name."_paralysis"])) {
            $char = $this->setParalysis($char_name, $save, $char, $skills[$use_skill_id]["paralysis"]);
        } else {
            //麻痺継続かの判断のためCOOKIEに入っている既存値を参照し、かつ麻痺であった場合
            $isParalysis = $_COOKIE[$char_name."_paralysis"] == "1";
            //別に三項演算である必要はない

            //$isPoisonに直接intの1を入力した場合はなぜか動かない。php -a 試した結果trueになっていた
            if ($isParalysis) {
                // キャラクターが麻痺であるとき
                // 麻痺のリフレッシュ処理を行う
                if ($this->refreshParalysis()) {
                    // 麻痺のリフレッシュ(治った)とき, キャラを麻痺falseにする

                    $char = $this->setParalysis($char_name, $save, $char, false);
                }
            } else { // キャラクターが麻痺ではないとき
                $char = $this->setParalysis($char_name, $save, $char, $skills[$use_skill_id]["paralysis"]);
            }
        }
        return $char;
    }


    /**
    * 麻痺情報を保存する
    *
    * @param String $char_name
    * @param Object $save
    * @param Object $char
    * @param Boolean $isParalysis
    * @return Object Char class
    */
    private function setParalysis(String $char_name, Object $save, Object $char, Bool $isParalysis): Object
    {
        //error_log($isParalysis ?"麻痺になった": "スキルは麻痺攻撃ではなかったもしくは麻痺にならなかった");

        //麻痺化計算を終えたtrueもしくはfalseをプロパティにセットする
        $char->setParalysis($isParalysis);

        //上記のプロパティ結果をCOOKIEにセットする
        //注意: setcookieのセットタイミングは2周目以降に適応

        $save->cookie($char_name. "_paralysis", $isParalysis ? "1": "0");

        return $char;
    }

    /**
     * 麻痺解除処理を行う
     *
     * @return boolean 麻痺解除成功 true
     */
    private function refreshParalysis(): Bool
    {
        // 1/2で麻痺解除処理
        if (50 > rand(0, 100)) {
            //error_log("麻痺が解除された");
            return true;
        }
        // 麻痺解除できないとき
        //error_log("麻痺の解除に失敗した");
        return false;
    }
}
