<?php
declare(strict_types=1);


require_once("char.php");

class Pinoko extends Char
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

    public function attack3()
    {
        $rand = rand(20, 200);
        return $rand;
    }

    public function attack4()
    {
        $rand = rand(20, 200);
        return $rand;
    }

    public function attack5()
    {
        $rand = rand(20, 200);
        return $rand;
    }
}
