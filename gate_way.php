<?php
session_start();

require_once("char.php");
require_once("skills.php");

$skillClass = new Skills();
$skill1 = $skillClass->getById(1);
$skill2 = $skillClass->getById(2);

$skills = array($skill1,$skill2);

$player = new Char(
    "たけし",
    1000,
    1000,
   //$skill
);

$pinoko = new Char(
    "ピノ子",
    10000,
    1000,
    $skills
);

require_once("command.php");

echo json_encode(get($player, $pinoko));
