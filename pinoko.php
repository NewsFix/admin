<?php
namespace BOUKEN\pinoko;

use BOUKEN\pinoko as firstEnemy;

class Pinoko
{
    public $name;
    public $HP = 10000;
    public $MP = 500;

    public function __construct($name)
    {
        $this->name = $name;
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

$pinoko = new Pinoko("ピノ子");
