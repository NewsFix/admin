<?php

require_once("char.php");
require_once("skills.php");

$skillClass = new Skills();
$skills = $skillClass->get();


$player = new Char(
    "たけし",
    500,
    500,
    $skills
);

$pinoko = new Char(
    "ピノ子",
    10000,
    1000,
    $skills
);

require_once("command.php");

$command = new Command();

echo json_encode($command->get($player, $pinoko));
