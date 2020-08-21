<?php
declare(strict_types=1);
header("Location:battle.php");
exit();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BOUKEN</title>
  <link rel="stylesheet" href="design.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/earlyaccess/nicomoji.css" rel="stylesheet">
</head>
<body>

  <div class="container">

    <div class="comment">
      <h1><font face="美咲ゴシック">
        <?php

        include_once("pinoko.php");

        echo $pinoko->attack1();
        sleep(1);

        ?>

      </h1>
    </div>

    <div class="battle">
      <img src="pinoko.png" alt="">
    </div>

    <div class="d-flex org-test">
      <div class="command">
        <ul>
          <li><form action="battle.php" method="post">
            <input type="submit" value="echo" name="attack" ></li>
          <li>スキル</li>
          <li>どうぐ</li>
          <li>にげる</li>
        </ul>
      </div>

      <div class="party">
        <div class="main-char">
          <ul>
            <li>ひろし</li>
            <li>HP:１００</li>
            <li>MP:１００</li>
            <li>職業:平民</li>
          </ul>
        </div>
      </div>

    </div>

 </div>


</body>
</html>
