<?php

/*
* スキルの一元管理を行う
*/

class Skills
{
    /**
     * skillsメソッド内にある配列を取得するため
     *
     * @param void
     * @return array スキルの入った配列を返す
     */
    public function get():array
    {
        return $this->createSkills();
    }

    /**
     * 作成したskillsメソッド内のID(key名)取得
     * 取得できない場合は空の配列が返る
     *
     * @param integer $skillID
     * @return array 任意のIDを指定して任意のスキルを取得
     */
    public function getById(int $skillID):array
    {
        $skills = $this->get();

        if (!isset($skills[$skillID])) {
            return array();
        } else {
            return $skills[$skillID];
        }
    }

    /**
     * 全てのスキルを配列形式で格納してあるメソッド
     *
     * @param void
     * @return array 全キャラのスキルを返す
     */
    private function createSkills():array
    {
        return [
          [
            "name" => "お注射",
            "addHP"=> 0,
            "damage"=> $this->randomDamage(50, 100),
            "useMP" => 0,
            "text" => "にお注射をねじ込んだ!!",
            "death" => $this->isDead(0),
            "poison" => $this->isPoison(100)
          ],

          [
            "name" => "解剖手術",
            "addHP"=> 0,
            "damage"=> 10,
            "useMP" => 0,
            "text" => "を解剖した",
            "death" => $this->isDead(20),
            "poison" => $this->isPoison(100)
          ],

          [
            "name" => "アッチョンプリケ",
            "addHP"=> 0,
            "damage"=> $this->randomDamage(200, 300),
            "useMP" => 0,
            "text" => "はのたうち回っている。",
            "death" => $this->isDead(0),
            "poison" => $this->isPoison(100)
          ],

          [
            "name" => "念力",
            "addHP"=> 0,
            "damage"=> $this->randomDamage(999, 999),
            "useMP" => 0,
            "text" => "はオペに失敗した....",
            "death" => $this->isDead(0),
            "poison" => $this->isPoison(100)
          ],

          [
            "name" => "echo",
            "addHP"=> 0,
            "damage"=> $this->randomDamage(30, 60),
            "useMP" => 0,
            "text" => "へ出力した。",
            "death" => $this->isDead(0),
            "poison" => $this->isPoison(0)
          ],

          [
            "name" => "変数定義",
            "addHP"=> 0,
            "damage"=> $this->randomDamage(0, 0),
            "useMP" => 0,
            "text" => "に対し変数を定義できない!!",
            "death" => $this->isDead(0),
            "poison" => $this->isPoison(0)
          ],

          [
            "name" => "カツアゲ",
            "addHP"=> 0,
            "damage"=> $this->randomDamage(30, 60),
            "useMP" => 0,
            "text" => "を強烈にカツアゲした!!",
            "death" => $this->isDead(0),
            "poison" => $this->isPoison(0)
          ],

          [
            "name" => "カッティングエッジ!",
            "addHP"=> 0,
            "damage"=> $this->randomDamage(50, 100),
            "useMP" => 0,
            "text" => "とは無関係に闇夜を切り裂いた!!",
            "death" => $this->isDead(0),
            "poison" => $this->isPoison(0)
          ],
        ];
    }

    /**
     * 引数ベースでランダム数字を発生させる
     *
     * @param integer $min
     * @param integer $max
     * @return integer 任意の引数で乱数の加減上限設定
     */
    private function randomDamage(int $min, int $max):int
    {
        return rand($min, $max);
    }

    /**
     * 即死率の定義
     *
     * @param int $dead_rate 即死率
     * @return bool
     */
    private function isDead(int $dead_rate):bool
    {
        $rate = rand(0, 100);
        return $rand < $dead_rate;
    }

    /**
     * 毒化率の定義
     *
     * @param int $poison_rate 即死率
     * @return bool
     */
    private function isPoison(int $poison_rate):bool
    {
        $rate = rand(0, 100);
        return $rate < $poison_rate;
    }
}
