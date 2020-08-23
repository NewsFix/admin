<?php

class Pinoko
{
    public $name;
    public $hp = 10000;
    public $mp = 500;
    public $skill = '';

    public function __construct($name, $hp, $mp, $skill)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->mp = $mp;
        $this->skill = $skill;
    }

    public function attack1()
    {
        return "50のダメージ!!";
    }

    public function attack2()
    {
        return "100のダメージ!!";
    }

    public function attack3()
    {
        return "150のダメージ!!";
    }

    public function attack4()
    {
        return "200のダメージ!!";
    }
}

