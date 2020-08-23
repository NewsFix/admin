<?php
session_start();


require_once("player.php");
require_once("pinoko.php");
require_once("status.php");



$player = new Player(
    "たけし",
    1000,
    1000,
    $skill
);

$enemy1 = new Pinoko(
    "ピノ子",
    1000,
    1000,
    $skill
);

require_once("command.php");


echo json_encode(get($player, $enemy1));
