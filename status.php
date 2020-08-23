<?php


function attackName():string
{
    return "ファイア";
}

(string) $attack_name = attackName();


$skill = array(
  "test" => "test1111",
  "tech1" => $attack_name
);
