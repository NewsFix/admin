<?php
session_start();

include_once("pinoko.php");


        function attack($pinoko)
        {
            $rand = rand(50, 200);
            if (!isset($_SESSION["HP"])) {
                $_SESSION["HP"] = $pinoko->HP;
            } else {
                $_SESSION["HP"] -= $rand;
            }
            $rand = strval($rand);
            $rand = mb_convert_kana($rand, "N");
            return "ひろしは".$pinoko->name."に".$rand ." のダメージを与えた!!";
        }


        $strike_text = "";

        if ($_REQUEST["attack"]) {
            $strike_text = attack($pinoko);
        } else {
            $strike_text = "$pinoko->name がおそいかかってきた!!!";
        }

        $value = array(
          "strike_text" => $strike_text,
          "pinoko_hp" => $_SESSION["HP"]);
          echo json_encode($value);
