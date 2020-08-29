<?php
session_start();

 //攻撃乱数が出来上がるまでの参考として以下を残しておく
 //最終的に削除予定

function attack($player, $pinoko)
{
    $rand = rand(50, 200);

    return text_of_attack_by_player($player->name, $pinoko->name, $rand)
}

function text_of_attack_by_player($player_name, $pinoko_name, $damage)
{
    // 乱数の値を文字化
    $damage_text = mb_convert_kana(strval($damage), "N");
    $player_text = $player_name. "はファイアを唱えた!!!";
    $pinoko_text = $pinoko_name. "に" . $damage . " のダメージを与えた!!";

    return $player_text . $pinoko_text
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
    $pinoko_rand = rand(0, count($pinoko->skills)-2);
    $strike_text = "";
    $enemy_strike_text = "";
    //$_SESSION["pinoko"] = serialize($pinoko);

    if (!isset($_COOKIE["player"])) {
        setcookie("player", $player);
    } else {
        //$pinokoで名称付しているのはダメージを与える当事者がpinokoのため
        $pinoko_use_skill = $pinoko->skills[$pinoko_rand];
        $pinoko_damage = $pinoko_use_skill["damage"];
        $player_hp = $player->hp - $pinoko_damage;
        $player->setHp($player_hp);
        $_COOKIE["player"] = $player;
    }

    if (!isset($_SESSION["pinoko"])) {
        //オブジェクト型をSESSIONへ代入する際は必ず
        //serialize化しないと入らない
        $_SESSION["pinoko"] = serialize($pinoko);
    } else {
        //$pinoko->skills)-2はスキル配列内のpinokoの技だけに限定するため
        $pinoko_rand = rand(0, count($pinoko->skills)-2);
        $pinoko = unserialize($_SESSION["pinoko"]);
        $pinoko_use_skill = $pinoko->skills[$pinoko_rand];
        $damage = $use_skill["damage"];
        $pinoko_hp = $pinoko->hp - $damage;
        $pinoko->setHp($pinoko_hp);
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
        "pinoko_hp" => "ピノコの現在HP:".$pinoko->hp,
        "player_hp" => "ひろしの現在HP:".$player->hp,
        "array_detail" => $skills
    );
}



 /**
 * 最終的な攻撃シーンを作成する。
 * 状況ごとに攻撃を行う確率を分ける
 */
