<?php

namespace Battle;

// データセーブを管理するClass
use Battle\SaveData;
/**
 * セーブデータを管理するクラス
 */
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
    public function calcPoisonStatus($char, $save, $skill_poison)
    {
        if (!isset($_COOKIE[$char->name."_poison"])) {
            //$_COOKIE[$char_name."_poison"]がCOOKIE配列に入っていない場合
            $char = $this->setPoison($save, $char, $skill_poison);
        } else {
            //毒継続かの判断のためCOOKIEに入っている既存値を参照し、かつ毒であった場合
            $isPoison = $_COOKIE[$char->name."_poison"] == "1"? true: false; //別に三項演算である必要はない

            if ($isPoison) { // キャラクターが毒であるとき
                // 毒のリフレッシュ処理を行う
                if ($this->refreshPoison()) {
                    // 毒のリフレッシュ(治った)とき, キャラを毒falseにする
                    $char = $this->setPoison($save, $char, false);
                } // 毒解除失敗時はなにもしない
            } else { // キャラクターが毒ではないとき
                $char = $this->setPoison($save, $char, $skill_poison);
            }
        }

        return $char;
    }


    /**
     * 毒状態のHP減算処理
     *
     * @param Boolean $isPoison 毒であるか
     * @param Int $hp HP
     * @return Int HP
     */
    public function calcPoisonDamage($isPoison, $hp)
    {
        // 毒の場合のみHP減算
        if ($isPoison) {
            $hp -= rand(10000, 20000);
        }

        return $hp;
    }

    /**
     * 毒情報を保存する
     *
     * @param Object $save
     * @param Object $char
     * @param 毒か否か
     * @return Object Char class
     */
    private function setPoison(Object $save, Object $char, Bool $isPoison): Object
    {
        error_log($isPoison ?"毒になった": "スキルは毒攻撃ではなかったもしくは毒にならなかった");
        //毒化計算を終えたtrueもしくはfalseをプロパティにセットする
        $char->setPoison($isPoison);
        //上記のプロパティ結果をCOOKIEにセットする
        //注意: setcookieのセットタイミングは2周目以降に適応
        $save->cookie($char->name. "_poison", $isPoison? "1": "0");

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
}
