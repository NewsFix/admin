<?php
declare(strict_types=1);


class Char
{
    public string $name;
    public int $hp;
    public int $mp;
    public array $skill;

    public function __construct(
        string $name,
        int $hp,
        int $mp,
        array $skills = []
    ) {
        $this->name = $name;
        $this->hp = $hp;
        $this->mp = $mp;
        $this->skills = $skills;
    }
}
