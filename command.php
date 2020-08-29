<?php
session_start();

 //攻撃乱数が出来上がるまでの参考として以下を残しておく
 //最終的に削除予定

function attack($player, $pinoko)
{
    $rand = rand(50, 200);


    //乱数を文字化するための目的

    $rand = strval($rand);
    $rand = mb_convert_kana($rand, "N");


    //主人公側の攻撃表示


    $player_text1 = $player->name. "はファイアを唱えた!!!";

    $player_text2 = $pinoko->name."に".$rand ." のダメージを与えた!!";

    return $player_text1 . $player_text2;
}


function enemy_attack($player, $pinoko)
{
    $rand = $pinoko->skills[0]['damage'];

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
    //$_SESSION["pinoko"] = serialize($pinoko);

    if (!isset($_SESSION["pinoko"])) {
        //オブジェクト型をSESSIONへ代入する際は必ず
        //serialize化しないと入らない
        $_SESSION["pinoko"] = serialize($pinoko);
    } else {
        $rand = rand(0, count($pinoko->skills));
        $pinoko = unserialize($_SESSION["pinoko"]);
        $use_skill = $pinoko->skills[$rand];
        $damage = $use_skill["damage"];
        $hp = $pinoko->hp - $damage;
        $pinoko->setHp($hp);
        $_SESSION["pinoko"] = serialize($pinoko);
    }

    if ($_REQUEST["attack"]) {
        $strike_text = attack($player, $pinoko);
        $enemy_strike_text = enemy_attack($player, $pinoko);
        $check = error_log(print_r($_SESSION["pinoko"], true));
    } else {
        $strike_text = "$pinoko->name がおそいかかってきた!!!";
    }

    return array(
        "strike_text" => $strike_text,
        "enemy_strike_text" => $enemy_strike_text,
        "pinoko_hp" => $pinoko->hp,
        "array_detail" => $skills
    );
}



 /**
 * 最終的な攻撃シーンを作成する。
 * 状況ごとに攻撃を行う確率を分ける
 */
