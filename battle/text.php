<?php

namespace Battle;

class Text
{

    /**
     * バトルのスキル使用表記
     *
     * @param String $target 攻撃対象
     * @param Int    $damage ダメージ
     * @return String ダメージ表記テキスト
     */
    public function useSkillText(String $skill_user, String $skill_text): String
    {
        return $skill_user. 'は'. $skill_text; // をXXしたをさらに分離してもよさそう
    }
    /**
     * バトルのダメージ表記
     *
     * @param String $target 攻撃対象
     * @param Int    $damage ダメージ
     * @return String ダメージ表記テキスト
     */
    public function damageText(String $target, Int $damage): String
    {
        // ダメージ数の表記は全角に置き換える
        return $target. 'に' .mb_convert_kana(strval($damage), 'N'). ' のダメージを与えた!!';
    }
}

