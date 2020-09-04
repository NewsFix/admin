<?php

class Human
{
    private string $name;
    private int $hp;
    private int $mp;
    private string $job;

    public function __construct(string $name, int $hp, int $mp, string $job)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->mp = $mp;
    }

    /**
     * ドリンクを飲むとHPが1回復する
     *
     * @return void
     */
    public function drink()
    {
        $this->hp += 1;
        $this->mp += 1;
    }

    /**
     * 食事をとるとHPが２回復する
     *
     * @return void
     */
    public function eat():void
    {
        $this->hp += 2;
        $this->mp += 2;
    }

    public function walk():void
    {
        $this->mp -= 1;
    }

    public function run():void
    {
        $this->mp -= 2;
    }

    public function mealLimit()
    {
        if ($this->hp>=10) {
            $this->hp = 10;
            $this->eat();
        } else {
            $this->eat();
        }
    }

    /**
     * 名前を取得する
     *
     * @return string 名前を返す
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     *  名前をセットする
     *
     * @param string $name
     *
     */
    public function setName(string $name):void
    {
        $this->name = $name;
    }

    public function getHP():int
    {
        return $this->hp;
    }
}
