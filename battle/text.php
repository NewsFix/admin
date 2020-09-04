<?php

namespace Battle;

class Text
{
    /**
     * バトルテキストの生成共通部分
     *
     * @param String $turn_char_name このターンメインで攻撃するキャラクタ名
     * @param String $use_skill_name 攻撃キャラが使うスキル名
     * @param String $use_skill_text 攻撃キャラが使うスキルテキスト
     * @param String $target_char_name 攻撃を受けるキャラ名
     * @param Int    $damage ダメージ
     * @return string 主人公の戦闘コメント結果
     */
    public function attackText(string $turn_char_name, string $use_skill_name, string $use_skill_text, string $target_char_name, int $damage):String
    {
        $skill_text = $this->useSkillText($turn_char_name, $use_skill_name, $use_skill_text, $target_char_name);
        $damage_text = $this->damageText($target_char_name, $damage);

        return $skill_text . $damage_text;
    }

    /**
     * バトルのスキル使用表記
     *
     * @param String $skill_user 攻撃者
     * @param String $skill_name スキル名
     * @param String $skill_text スキルテキスト
     * @param String $target_user 攻撃対象者
     * @return String ダメージ表記テキスト
     */
    private function useSkillText(String $skill_user, String $skill_name, String $skill_text, String $target_user): String
    {
        return $skill_user. 'の'.$skill_name ."!!". $target_user.$skill_text; // をXXしたをさらに分離してもよさそう
    }

    /**
     * バトルのダメージ表記
     *
     * @param String $target 攻撃対象
     * @param Int    $damage ダメージ
     * @return String ダメージ表記テキスト
     */
    private function damageText(String $target, Int $damage): String
    {
        // ダメージ数の表記は全角に置き換える
        return $target. 'に' .mb_convert_kana(strval($damage), 'N'). ' のダメージを与えた!!';
    }
}
