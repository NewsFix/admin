<?php

/**
 * キャラクターのステータス計算で利用する
 * 全てのHP, MP計算をここで行うと楽
 *
 */
class CalcCharacterStatus
{
    // HP最低値 基本は0
    const DEFAULT_MINIMUM_HP = 0;

    // MP最低値 基本は0
    const DEFAULT_MINIMUM_MP = 0;

    /**
     * HPダメージ計算を行う
     *
     * @param  Integer $baseHp            計算のベースとなるHP
     * @param  Integer $calculationStatus ダメージ
     * @param  Boolean $death             即死かどうか
     * @param  Integer $minimumHp         HP最低値 マイナス状態でも生きてるバーサーカーみたいなときに外から入れる
     *
     * @return 計算結果HP
     */
    public function subtractionHp(Int $baseHp, Int $calculationStatus, Boolean $death = false, Int $minimumHp = self::DEFAULT_MINIMUM_HP)
    {
        // 即死の場合HP最低値を返す
        if ($death) {
            return $minimumHp;
        }

        // HP最低値以下になったらそれを返す
        if ($minimumHp =< ($baseHp - $calculationStatus)) {
            return $minimumHp;
        }

        return $baseHp - $calculationStatus;
    }

    /**
     * HP回復計算を行う
     *
     * @param  Integer $baseHp            計算のベースとなるHP
     * @param  Integer $calculationStatus 回復値
     *
     * @return 計算結果HP
     */
    public function addHp(Int $baseHp, Int $calculationStatus)
    {
        return $baseHp + $calculationStatus;
    }

    /**
     * MP減算を行う
     *
     * @param  Integer $baseMp            計算のベースとなるMp
     * @param  Integer $calculationStatus 引かれるMP
     *
     * @return 計算結果HP
     */
    public function subtractionMp(Int $baseMp, Int $calculationStatus)
    {
        $minimumMp = self::DEFAULT_MINIMUM_MP;
        // MP最低値以下になったらそれを返す
        if ($minimumMp =< ($baseMp - $calculationStatus)) {
            return $minimumMp;
        }

        return $baseMp - $calculationStatus;
    }

    /**
     * MP加算を行う
     *
     * @param  Integer $baseMp            計算のベースとなるMp
     * @param  Integer $calculationStatus 足されるMP
     *
     * @return 計算結果HP
     */
    public function addMp(Int $baseMp, Int $calculationStatus)
    {
        return $baseMp + $calculationStatus;
    }
}
