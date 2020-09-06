      function asyncSend(){
        /**
         * PHPのPOSTリクエストを利用しながら同一ファイル内でBGMを流すためにaudioタグ入りのHTMLとAJAXでPOST送信するファイルを切り離して使用する
         */

        //AJAX仕様について:
        //1:XMLHttpRequest()実体化し変数代入
        //2:代入した変数に組込関数(onload等)で実行タイミングを指定。
        //3:代入予定のクロージャ内で仕組みを作っていく。下記ではAJAXを利用してinnerHTMLにより特定のタグ内にStringを挿入する
        //4: battle.phpで行われたForm(POSTメソッド)の送信は実質的にAJAXによりgate_way.phpファイルから送信される


        var req = new XMLHttpRequest();

          req.onload = function() {

            var foo = req.response;

            var result = document.getElementById('result');

            var pinoko_value = document.getElementById('enemy_status');

            var player_value = document.getElementById('player_status');

            var player_poison_check = document.getElementById('player_poison_check');

            var player_hp = document.getElementById('player_hp');

            var player_mp = document.getElementById('player_mp');

            if(req.status == 200){

              //最終送信元のgate_way.phpで受け取ったレスポンスデータはPHP仕様となっているためJSで利用するためにJSON仕様に変換するためにJSON.parseを用いる

              //注意: gate_way.phpファイル側でもjson_encode関数でエンコード変換を行なっているため、両ファイルでの変換処理必要。

              var data = JSON.parse(req.responseText);

              const current_player_hp = "現在" + data.player.name + "のHP:" + data.player.hp;
              const current_enemy_hp = "現在" + data.pinoko.name + "のHP:" + data.pinoko.hp;
              const current_poison_check = "現在の毒化:" + data.player.poison;

              //JSON.parse処理が完了しているので、以下phpファイルで定義した各変数が使用可能となっている
              result.innerHTML = data.strike_text;
              pinoko_value.innerHTML = current_enemy_hp;
              player_value.innerHTML = current_player_hp;
              player_poison_check.innerHTML = current_poison_check;
              //敵のスキルに合わせてHP増減をさせるためタイムラグを生じさせている
              var player_hp_text = function(){
                player_hp.innerHTML = data.player.hp;
              }
              setTimeout(player_hp_text,2000);
              player_mp.innerHTML = data.player.mp;

              // TODO: デバッグ用
              console.log(data.player.death? "死んだ": "死ななかった");

              //敵側のテキストを攻撃者と同じ"id=result"タグ内に挿入するためsetTimeoutにて時間差をつけている。
              //クロージャ入り変数の仕組みは単に上記のinnerHTMLと同じ。
              var enemy_response = function() {
              result.innerHTML = data.enemy_strike_text;
              }

              setTimeout(enemy_response,2000);
            }
          }

        //インスタンス化したAJAX用変数 + openでform送信形式、送り元ファイル、AJAXの利用の有無を指定
        req.open('POST',"gate_way.php",true);

        //仕様の再確認必要。header情報の設定目的か。
        req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded;charset=UTF-8');

        //openとsendはセット。注意点としてgetの場合はクエリパラメータもopenの第２パラメータに挿入し、sendはvoidでOK

        //post形式で送る場合はクエリパラメータはsendの括弧内に挿れよう。
        req.send("attack=echo");
      }
