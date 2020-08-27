<?php
session_start();

// 不必要の可能性
//require_once("char.php");

// 攻撃乱数が出来上がるまでの参考として以下を残しておく


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

    //主人公側の攻撃表示

    $player_text1 = $player->name. "は
    ファイアを唱えた!!!";

    $player_text2 = $pinoko->name."に".$rand ." のダメージを与えた!!";

    return $player_text1 . $player_text2;
}

function enemy_attack($player, $pinoko)
{
    $rand = rand(200, 1000);

    $rand = strval($rand);
    $rand = mb_convert_kana($rand, "N");


    $pinoko_text1 = $pinoko->name. "は".
    $pinoko->skills[0]['text'];

    $pinoko_text2 = $player->name."に".$rand ." のダメージを与えた!!";

    return $pinoko_text1 . $pinoko_text2;
}

function get($player, $pinoko)
{
    $strike_text = "";
    $enemy_strike_text = "";


    if ($_REQUEST["attack"]) {
        $strike_text = attack($player, $pinoko);
        $enemy_strike_text = enemy_attack($player, $pinoko);
    } else {
        $strike_text = "$pinoko->name がおそいかかってきた!!!";
    }

    return array(
        "strike_text" => $strike_text,
        "enemy_strike_text" => $enemy_strike_text,
        "pinoko_hp" => $_SESSION["hp"],
        "array_detail" => $skill
    );
}
