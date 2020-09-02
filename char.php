<?php
declare(strict_types=1);

/**
 * 全てのキャラクターの原型クラス。各キャラの個性は引数にて
 * 名前,HP,MP,skillを渡していく
 */
class Char
{
    public string $name;
    public int $hp;
    public int $mp;
    public array $skills;

    public function __construct(string $name, int $hp, int $mp, array $skills = [])
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->mp = $mp;
        $this->skills = $skills;
        $this->isDeath = false; // 死の状態デフォルトfalseだから引数には入れていない
    }

    /**
     * キャラクタステータスを配列に入れて返す
     * TODO: command phpに書くのがいい気がするけどいったんここで
     *
     * @return Array ステータスの塊
     */
    public function getStatus(): Array
    {
        return array(
            "name" => $this->name,
            "hp" => $this->hp,
            "mp"=> $this->mp,
            "death" => $this->death, // 死んでいたらtrue
        );
    }

    /**
     * SESSIONもしくはCOOKIEへのHP設定用のセッター。
     * 初期設定のHPはconstructで実行する。
     *
     * @param int $hp
     * @return void HPをプロパティへ格納
     */
    public function setHp(int $hp):void
    {
        $this->hp = $hp;
    }
    /**
     * 死亡状況をセットする
     *
     * @param bool $death 死んでたらtrue
     * @return void HPをプロパティへ格納
     */
    public function setDeath(bool $death):void
    {
        $this->death = $death;
    }

}
