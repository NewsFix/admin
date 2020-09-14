<?php

namespace Battle;

/**
 * セーブデータを管理するクラス
 */
class SaveData
{
    /**
     * cookieをセットする
     *
     * @param $key cookieのキーとなる名前
     * @param $value cookieに入れる値
     * @param $expire cookieの期限
     * @return void
     */
    public function cookie($key, $value, $expire = 60*60):void
    {
        // 値をセットするためにkeyが存在する場合はまず消す
        if (isset($_COOKIE[$key])) {
            setcookie($key, "", time()-$expire, "/");
        }
        // 実際にセットする
        setcookie($key, $value, time()+$expire, "/");
    }

    //unsetについて
        /*
        * unsetは変数の割り当て解除であり、自分のPC側で存在が消えたよう* に見えるが、COOKIE内には残存し続けるので注意。
        * 確実にCOOKIEの値を消したい場合はsetcookieでの現在時刻を過去* に戻す処理を行う必要がある。(SESSIONに関しては未確認のため要確* 認)
        */

        /**
         * MEMO: setcookie()は
         * 第一パラメータ:COOKIE名
         * 第二パラメータ:格納データ
         * 第三パラメータ:有効期限(グリニッジ標準)
         * 第四パラメータ:使用可能なルートの設定
         */
}
