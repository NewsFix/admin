<?php
declare(strict_types=1);
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
    <font face="美咲ゴシック"><h1 id="result"></h1>
    </div>

    <div class="battle">
    <img src="pinoko.png" alt="">
    </div>

    <div class="d-flex org-test">
    <div class="command">
      <ul>
        <li><form name="fm" action='battle.php' method='post'>
          <input type='button'
          name='attack' value='echo' onclick="asyncSend();"></form>
        </li>
        <li>スキル</li>
        <li>どうぐ</li>
        <li>にげる</li>
      </ul>
    </div>

    <div class="d-flex party">
      <div class="main-char">
        <ul>
          <li>ひろし</li>
          <li>HP:１００</li>
          <li>MP:１００</li>
          <li>職業:平民</li>
        </ul>
      </div>
      <div class="session_info">
        <p id="enemy_status"></p>
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

  <script>
    function asyncSend(){
      var req = new XMLHttpRequest();
      //下記の方法で受け取ったコードをJSON形式で受け取れるようにしているが、実装可能かは不明
      //req.responseType = "json";


      req.onload = function() {

      var foo = req.response;

      var result = document.getElementById('result');

      var value = document.getElementById('enemy_status');

      if(req.status == 200){
      var data = JSON.parse(req.responseText);

      result.innerHTML = data.strike_text;
      value.innerHTML = data.pinoko_hp;

      var enemy_response = function() {
      result.innerHTML = data.enemy_strike_text;
      }
      setTimeout(enemy_response,1000);
      }

      }

      req.open('POST',"gate_way.php",true);
      req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded;charset=UTF-8');
      req.send("attack=echo");

    }
  </script>

  </body>
  </html>
