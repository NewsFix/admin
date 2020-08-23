<?php
session_start();

include_once("pinoko.php");

function attack($player, $pinoko)
{
    $rand = rand(50, 200);
    if (!isset($_SESSION["hp"])) {
        $_SESSION["hp"] = $pinoko->hp;
    } else {
        $_SESSION["hp"] -= $rand;
    }
    $rand = strval($rand);
    $rand = mb_convert_kana($rand, "N");

    $player_text = $player->name. "は". $pinoko->skill["tech1"]."を唱えた!!!";
    $pinoko_text = $pinoko->name."に".$rand ." のダメージを与えた!!";

    return $player_text . $pinoko_text;
}

function get($player, $pinoko)
{
    $strike_text = "";

    if ($_REQUEST["attack"]) {
        $strike_text = attack($player, $pinoko);
    } else {
        $strike_text = "$pinoko->name がおそいかかってきた!!!";
    }

    return array(
        "strike_text" => $strike_text,
        "pinoko_hp" => $_SESSION["hp"]
    );
}
