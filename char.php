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
    public bool $dead;

    public function __construct(string $name, int $hp, int $mp, array $skills = [])
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->mp = $mp;
        $this->skills = $skills;
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

    public function setDead(bool $is_dead):void
    {
        %this->dead = $is_dead;
    }
}
