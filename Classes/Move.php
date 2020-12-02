<?php

/**
* 技
*/
abstract class Move
{
    /**
    * 優先度(初期値)
    * @var integer
    */
    public const PRIORITY = 0;

    /**
    * 急所ランク(初期値)
    * @var integer
    */
    public const CRITICAL = 0;

    /**
    * チャージ中に回避できない技
    * @return array
    */
    public const CANT_EXCAPE_MOVE = [];

    /**
    * フラグ関係(初期値)
    * @var boolean
    */
    // チャージ
    public const CHARGE_FLG = false;
    // 一撃必殺
    public const ONE_HIT_KNOCKOUT_FLG = false;
    // 能力下降確定技
    public const CONFIRM_DEBUFF_FLG = false;
    // 固定ダメージ技
    public const FIXED_DAMAGE_FLG = false;

    /**
    * メッセージ関係の初期値
    * @var string
    */
    // 攻撃失敗
    protected const FAILED_MSG = 'しかし::pokemonの攻撃は外れた！';
    // 一撃必殺失敗
    protected const ONE_HIT_KNOCKOUT_FAILED_MSG = '::pokemonには全然効いていない！';

    /**
    * フィールド効果
    * @var array
    */
    public static $field = [];

    /**
    * タイプ名の取得
    * @return string
    */
    public static function getTypeName()
    {
        $type = static::TYPE;
        return $type::NAME;
    }

    /**
    * チャージ効果
    * @param atk:object::Pokemon
    * @return bool
    */
    public static function charge($atk)
    {
        // チャージ不要
        return false;
    }

    /**
    * 技失敗時のアクション
    * @param atk:object::Pokemon
    * @return void
    */
    public static function failed($atk){}

    /**
    * 技回数(ランダムの場合があるのでメソッドを使用)
    * @return integer
    */
    public static function times(): int
    {
        // デフォルトは1
        return 1;
    }



    /**
    * 反動
    * @param args:array::mixed
    * @return boolean
    */
    public static function recoil(...$args)
    {
        return false;
    }

    /**
    * コスト（技の失敗時も含む）
    * @param mixed
    * @return boolean
    */
    public static function cost(...$args)
    {
        return false;
    }

    /**
    * 追加効果（ダメージ計算後に実行）
    * @param mixed
    * @return void
    */
    public static function effects(...$args){}

    /**
    * 能力下降効果（ダメージ計算後に実行）
    * @param mixed
    * @return void
    */
    public static function debuff(...$args){}

    /**
    * 威力補正値の取得(引数に合わせて補正値が異なるためメソッド)
    * @param args:array::mixed
    * @return integer
    */
    public static function powerCorrection(...$args): int
    {
        return 1;
    }

    /**
    * 一撃必殺の命中率計算
    * @param atk::object::Pokemon
    * @param def::object::Pokemon
    * @return integer
    */
    public static function getOneHitKnockoutAccuracy(object $atk, object $def): int
    {
        if($atk->getLevel() > $def->getLevel()){
            // 相手のレベルより高ければ超過分を命中率にプラスする
            return static::ACCURACY + ($atk->getLevel() - $def->getLevel());
        }else{
            return static::ACCURACY;
        }
    }

    /**
    * 補正値計算込みの使用回数取得
    * @param correction:integer::補正値
    * @return integer
    */
    public static function getPp(int $correction=0): int
    {
        return static::PP + (floor(static::PP / 5) * $correction);
    }

    /**
    * 攻撃失敗時のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public function getFailedMessage($pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::FAILED_MSG);
    }

    /**
    * 一撃必殺失敗時のメッセージを取得
    * @param pokemon:string
    * @return string
    */
    public function getOneHitKnockoutFailedMessage($pokemon): string
    {
        return str_replace('::pokemon', $pokemon, static::ONE_HIT_KNOCKOUt_FAILED_MSG);
    }

}
