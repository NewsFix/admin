<?php

class Player
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
}
