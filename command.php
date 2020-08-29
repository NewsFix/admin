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
    $pinoko_rand = rand(0, count($pinoko->skills)-2);
    $strike_text = "";
    $enemy_strike_text = "";
    //$_SESSION["pinoko"] = serialize($pinoko);


    if (!isset($_COOKIE["player_hp"])) {
        setcookie("player_hp", $player->hp, time()+60*60, "/");
    } else {
        $player->hp = $_COOKIE["player_hp"];
        //$pinokoで名称付しているのはダメージを与える当事者がpinokoのため
        $pinoko_use_skill = $pinoko->skills[$pinoko_rand];
        $pinoko_damage = $pinoko_use_skill["damage"];
        $player_hp = $player->hp - $pinoko_damage;
        setcookie("player_hp", "", time()-60*60, "/");
        setcookie("player_hp", $player_hp, time()+60*60, "/");
    }

    if (!isset($_SESSION["pinoko"])) {
        //オブジェクト型をSESSIONへ代入する際は必ず
        //serialize化しないと入らない
        $_SESSION["pinoko"] = serialize($pinoko);
    } else {
        //$pinoko->skills)-2はスキル配列内のpinokoの技だけに限定するため
        $player_rand = rand(2, count($pinoko->skills)-1);
        $pinoko = unserialize($_SESSION["pinoko"]);
        $player_use_skill = $player->skills[$player_rand];
        $player_damage = $player_use_skill["damage"];
        $pinoko_hp = $pinoko->hp - $player_damage;
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

    //TODO:テストのため使用。テスト後削除しましょう。
    //var_dump($_COOKIE);


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
