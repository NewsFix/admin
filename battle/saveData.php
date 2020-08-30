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
    public function cookie($key, $value, $expire = 60*60)
    {
        // 値をセットするためにkeyが存在する場合はまず消す
        if (isset($_COOKIE[$key])) {
            setcookie($key, '', time()-$expire, "/");
        }
        // 実際にセットする
        setcookie($key, $value, time()+$expire, "/");

    }
    /**
     * MEMO: setcookie()は
     * 第一パラメータ:COOKIE名
     * 第二パラメータ:格納データ
     * 第三パラメータ:有効期限(グリニッジ標準)
     * 第四パラメータ:使用可能なルートの設定
     */

}
