<?php

require_once("char.php");

class Player extends Char
{
    public function attack1()
    {
        $rand = rand(20, 200);
        return $rand;
    }

    public function attack2()
    {
        $rand = rand(20, 200);
        return $rand;
    }
}
