<?php
session_start();

//攻撃乱数が出来上がるまでの参考として以下を残しておく
//主人公、敵側の関数内容に一貫性がない。修正必要

/**
 * 主人公側の攻撃
 *
 * @param object $player
 * @param object $pinoko
 * @return string 主人公の戦闘コメント結果
 */
function attack(object $player, object $pinoko):string
{
    $rand = rand(50, 200);

    //乱数のキャストをstringに変換。
    //最終的に渡すコメントの型を統一するため
    $rand = strval($rand);
    $rand = mb_convert_kana($rand, "N");

    //主人公側の攻撃表示
    $player_text1 = $player->name. "はファイアを唱えた!!!";
    $player_text2 = $pinoko->name."に".$rand ." のダメージを与えた!!";

    return $player_text1 . $player_text2;
}

/**
 * 敵側の攻撃
 *
 * @param object $player
 * @param object $pinoko
 * @return string 敵側の戦闘コメント結果
 */
function enemy_attack(object $player, object $pinoko):string
{
    /*
    * skills.php内で定義しているスキルの配列内容にrandを
    * 定義してあるので使用
    */
    $rand = $pinoko->skills[0]['damage'];

    //乱数のキャストをstringに変換。
    //最終的に渡すコメントの型を統一するため
    $rand = strval($rand);
    $rand = mb_convert_kana($rand, "N");

    /*
    * skills.php内で定義しているスキルの配列内容にスキル* textを定義してあるので使用
    */
    $pinoko_text1 = $pinoko->name. "は".
    $pinoko->skills[0]['text'];

    $pinoko_text2 = $player->name."に".$rand ." のダメージを与えた!!";

    return $pinoko_text1 . $pinoko_text2;
}

/**
 * 主人公と敵側のHP,MPの加算減算処理
 * 現在、主人公はCOOKIE側、敵側は SESSIONで保持して計算
 * PHP練習目的のため不統一だが、最終的に統一予定。
 *
 * POST形式、FORM送信後のデータ受け取りをトリガーに戦闘コメ* ントを配列にしgate_way.phpに渡す。その後jsonエンコード* 処理を経てbattle.phpでJSを用いてコメント内容を使用
 *
 * @param object $player
 * @param object $pinoko
 * @return array 敵味方コメントとHP
 */
function get(object $player, object $pinoko):array
{
    $strike_text = "";
    $enemy_strike_text = "";

    /*$COOKIE内に主人公HPが未定義なら生成。定義済みなら
    * else内でHPの更新処理
    */
    //COOKIE,SESSIONいずれも挿入する情報は必要最低限にする。HP,MP意外戦闘で不必要な情報は不要。
    /*setcookie()は
    * 第一パラメータ:COOKIE名
    * 第二パラメータ:格納データ
    * 第三パラメータ:有効期限(グリニッジ標準)
    * 第四パラメータ:使用可能なルートの設定
    */
    if (!isset($_COOKIE["player_hp"])) {
        setcookie("player_hp", $player->hp, time()+60*60, "/");
    } else {
        //count内のskill配列には全キャラスキルが格納されているためスキル乱数発生の際はキャラ毎のスキル範囲を指定する必要あり。
        $pinoko_rand = rand(0, count($pinoko->skills)-2);


        //敵側が使用するスキルは乱数発生
        //データ保持にCOOKIEを使用する場合は一旦COOKIE削除処理を行い、空ににした後に更新されたプロパティをCOOKIEに再セットする
        $player->hp = $_COOKIE["player_hp"];
        $pinoko_use_skill = $pinoko->skills[$pinoko_rand];
        $pinoko_damage = $pinoko_use_skill["damage"];
        $player_hp = $player->hp - $pinoko_damage;
        setcookie("player_hp", "", time()-60*60, "/");
        setcookie("player_hp", $player_hp, time()+60*60, "/");
    }

    /*$SESSION内に敵側HPが未定義なら生成。定義済みなら
    * else内でHPの更新処理
    */
    //SESSIONへobjectを格納する際はserializeで必ず使用。使用しないと入らない。
    //逆にSESSIONからオブジェクト情報を抽出する際はunserializeを必ず使用。
    if (!isset($_SESSION["pinoko"])) {
        $_SESSION["pinoko"] = serialize($pinoko);
    } else {
        $player_rand = rand(2, count($player->skills)-1);
        $pinoko = unserialize($_SESSION["pinoko"]);
        $player_use_skill = $player->skills[$player_rand];
        $player_damage = $player_use_skill["damage"];
        $pinoko_hp = $pinoko->hp - $player_damage;
        $pinoko->setHp($pinoko_hp);

        //object情報を更新しSESSION格納の際は必ずserialize使用!!
        $_SESSION["pinoko"] = serialize($pinoko);
    }

    /**
     * POST取得をトリガーに戦闘コメントの変数代入
     */
    if ($_REQUEST["attack"]) {
        $strike_text = attack($player, $pinoko);
        $enemy_strike_text = enemy_attack($player, $pinoko);
        $check = error_log(print_r($_SESSION["pinoko"], true));
    } else {
        $strike_text = "$pinoko->name がおそいかかってきた!!!";
    }

    //取得した戦闘コメント、更新された各オブジェクトのHPプロパティを配列化して返す。呼び出しはgate_way.phpより行う。
    return array(
        "strike_text" => $strike_text,
        "enemy_strike_text" => $enemy_strike_text,
        "pinoko_hp" => "ピノコの現在HP:".$pinoko->hp,
        "player_hp" => "HP:".$player->hp,
        "player_mp" => "MP:".$player->mp,
        "array_detail" => $skills
    );
}
