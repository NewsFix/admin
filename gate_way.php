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

/**
 * command.phpでの戻り値である配列をbattle.phpにおいてJSで
 * 使用するための前段階でエンコードをJSON形式に変更している
 *
 * 注意:battle.php内でもJSにおいてJSON.parseを利用した処理は必要。
 */
echo json_encode(get($player, $pinoko));
