<?php

class SkillsSample
{
    /**
     * スキル全体を返す
     * @param Void
     * @return Array スキル全て
     */
    public function get()
    {
        return $this->skills();
    }

    /**
     * スキルID指定でスキル単体を取得
     * @param String $skillId スキルのID
     * @return Array スキル単体
     */
    public function getById($skillId)
    {
        $skills = $this->get();

        // 存在しないIDが指定されたら空配列
        if (!isset($skills[$skillId])) {
            return array();
        }

        return $skills[$skillId];
    }
    /**
     * skill_id => 
     *           name 技名
     *           damage 技ダメージ
     *           addHp 回復値
     *           useMp 消費MP
     */
    private function skills()
    {
        return [
            '001' => [
                'name': 'お注射',
                'damage': 0,
                'addHp': $this->randomDamage(1, 10),
                'useMp': 0,
                'death': $this->isDeath(0),
                'text': "お注射を発動した！",
            ],
            '002' => [
                'name': 'アッチョンブリケ',
                'damage': 10,
                'addHp': 0, // 0 だから回復しない
                'useMp': 0,
            ],
            '003' => [
                'name': 'なのさ',
                'damage': 100,
                'addHp': 0,
                'useMp': 10,
            ],
        ];
    }

    private function randomDamage($min, $max)
    {
        return rand($min, $max);
    }

    /**
     * @param Int 確率最小値
     *
     */
    private function isDeath($min)
    {
        // いい感じのロジックを描く
        return $min;
    }
}


/**
 * TODO 利用イメージ
 */
$skillClass = new SkillsSample();
$skill = $skillClass->getById('001');

echo $skill['name'];
echo $skill['text'];
echo $skill['damage']; // これを計算式にぶち込む
