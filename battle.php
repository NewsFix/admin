<?php 
// CSSがブラウザキャッシュされるのでいい感じにしたいけどいったんこれで
$cssGeneration = rand(0, 9999);
?>
<!--idやnameの名称が分かりにくい。リファクタリング必須-->

<!DOCTYPE html>
  <html lang="ja">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>BOUKEN</title>
      <link rel="stylesheet" href="design.css?<?php echo $cssGeneration;?>">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/earlyaccess/nicomoji.css" rel="stylesheet">
      </head>

    <body>

    <!-- class=containerでBootStrapにてbody以下全て指定:全体の余幅調整目的 -->
      <div class="container">

        <div class="comment">
          <!-- "id=result"の箇所にJSにてinnnerHTMLで
          コメント取得 -->
          <!--<font face="美咲ゴシック">-->
          <h1 id="system-message"></h1>
        </div>

        <!-- 中央箇所に相手キャラクターの画像表示 -->
        <div class="battle">
          <img src="pinoko.png" alt="">
        </div>

        <div class="d-flex org-test">
          <div class="command">
          <ul>
          <li><form name="fm" action='battle.php' method='post'>
            <input type='button' name='attack' value='echo' onclick="asyncSend();"></form>
          </li>
          <li>スキル</li>
          <li>どうぐ</li>
          <li>にげる</li>
          </ul>
          </div>

          <div class="d-flex party">
            <div class="main-char">
            <ul>
              <li id="player_name">ひろし</li>
              <li id="player_hp"></li>
              <li id="player_mp"></li>
              <li>職業:PHPer</li>
            </ul>
            </div>
            <div class="session_info">
            <p id="enemy_status"></p>
            <p id="player_status"></p>
            <p id="player_poison_check"></p>
            </div>
          </div>

          </div>
        </div>

    <audio id="audio" muted loop>
      <source src="pinoko.mp3" type="audio/mp3">
      <source src="pinoko.wav" type="audio/wav">
    </audio>

    <script type="text/javascript">
      var audio = new Audio("pinoko.mp3");

      function play() {
      audio.loop = true;
      audio.volume = 0;
      audio.play();
      }
      play();

    </script>

    <script src="public/js/main.js"></script>

    </body>
  </html>
