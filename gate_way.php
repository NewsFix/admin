<?php

/**
 * AJAXを利用し、全てのPHPファイルをbattle.php内のformを
 * トリガーにこちらから送信する仕組みになっている。
 *
 * char.php:各キャラのクラスが定義されている
 * skills.php:各キャラの全スキルが配列で定義されている
 */
require_once("char.php");
require_once("skills.php");

$skillClass = new Skills();
$skills = $skillClass->get();


$player = new Char(
    "ひろし",
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

error_log(print_r($_COOKIE, true));

echo json_encode($command->get($player, $pinoko));
