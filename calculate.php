<?php
/**
 * キャラのダメージ計算利用
 * HP,MPの増減計算を行う
 */

 class CalcStatus
 {
     // HPのデフォルトを指定
     const DEFAULT_MIN_HP = 0;

     // MPのデフォルトを指定
     const DEFAULT_MIN_MP = 0;

     /**
      * HPの減算処理
      *
      *
      * @param int $baseHp
      * @param int $calStatus
      * @param bool $death
      * @param int $minimumHp
      * @return int HP減算結果
      */
     public function substractionHP(int $baseHp, int $calStatus, bool $death = false):int
     {
         $minimumHp = self::DEFAULT_MIN_HP;

         if ($death) {
             return $minimumHp;
         }

         //HPが0以下になったらデフォルトの値に戻る
         if ($minimumHp >= $baseHp - $calStatus) {
             return $minimumHp;
         }

         return $baseHp - $calStatus;
     }

     /**
      * HP回復用
      * HP加算処理
      *
      * @param int $baseHp
      * @param int $calStatus
      * @return int 回復結果
      */
     public function addHp(int $baseHp, int $calStatus):int
     {
         return $baseHp + $calStatus;
     }

     /**
      * MP減算処理
      *
      * @param int $baseMp
      * @param int $calStatus
      * @return int MPの減算結果
      */
     public function subtractionMp(int $baseMp, int $calStatus):int
     {
         $minimumMp = self::DEFAULT_MIN_MP;

         //MPが0になったらデフォルトの値に戻る
         if ($minimumMp <= $baseMp - $calStaus) {
             return $minimumMp;
         }

         return $baseMp - $calStatus;
     }


     /**
      * MPの使用が可能かどうかを定義する
      * 使用できない場合はfalseが返る
      *
      * @see 以下利用例
      * if isUseMp (5,10) {
      * $result = subtractionMp(5,10);
      * //isUseMpでのfalse検証MPの値と実際の消費MPがずれることは考えにくい
      * }
      * $thisに入れて計算結果を使いまわさないのは利用箇所でバグをはらんだロジックが生まれやすそうだから
      *
      * @param int $baseHp
      * @param int $calStatus
      * @return bool MP利用の可否
      */
     public function isUseMp(int $baseMp, int $calStatus):bool
     {
         $minimumMp = self::DEFAULT_MIN_MP;

         if ($minimumMp >= $baseMp - $calStatus) {
             return false;
         }

         return true;
     }

     /**
      * MPの加算処理
      *
      * @param int $baseMp
      * @param int $calStatus
      * @return int MP加算結果
      */
     public function addMp(int $baseMp, int $calStatus):int
     {
         return $baseMp - $calStatus;
     }
 }
