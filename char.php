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
    public bool $death;
    public bool $poison;
    public bool $paralysis;

    public function __construct(string $name, int $hp, int $mp, array $skills = [])
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->mp = $mp;
        $this->skills = $skills;
        $this->death = false; // 死の状態デフォルトfalseだから引数には入れていない
        $this->poison = false;
    }

    /**
     * キャラクタステータスを配列に入れて返す
     * TODO: command phpに書くのがいい気がするけどいったんここで
     *
     * @return Array ステータスの塊
     */
    public function getStatus(): array
    {
        return array(
            "name" => $this->name,
            "hp" => $this->hp,
            "mp"=> $this->mp,
            "death" => $this->death, // 死んでいたらtrue
            "poison" => $this->poison
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
     * SESSIONもしくはCOOKIEへのMP設定用のセッター。
     * 初期設定のMPはconstructで実行する。
     *
     * @param int $mp
     * @return void HPをプロパティへ格納
     */
    public function setMp(int $mp):void
    {
        $this->mp = $mp;
    }

    /**
     * 死亡状況をセットする
     *
     * @param bool $death 死んでたらtrue
     * @return void true/falseをプロパティへ格納
     */
    public function setDeath(bool $death):void
    {
        $this->death = $death;
    }

    /**
     * 毒化状況をセットする
     *
     * @param bool $poison 毒化していたらtrue
     * @return void true/falseをプロパティへ格納
     */
    public function setPoison(bool $poison):void
    {
        $this->poison = $poison;
    }

    /**
     * 麻痺状況をセットする
     *
     * @param bool $death 麻痺していたらtrue
     * @return void true/falseをプロパティへ格納
     */
    public function setParalysis(bool $paralysis):void
    {
        $this->paralysis = $paralysis;
    }
}
