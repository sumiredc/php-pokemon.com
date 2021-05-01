<?php

require_once app_path('Classes/Move.php');

// がまん
class MoveBide extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'がまん';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'わざを使用してから2ターン後の自分の行動までがまん状態になり、その間に受けたダメージを2倍にして返す。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 10;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

	/**
    * 優先度
    * @var integer
    */
    public const PRIORITY = 1;

	/**
    * 固定ダメージフラグ
    * @var boolean
    */
    public const FIXED_DAMAGE_FLG = true;

	/**
    * 攻撃発動メッセージ
    * @var string
    */
	protected const TRIGGER_MSG = '::pokemonの、がまんが解かれた！';

	/**
    * がまん 開始
    *
    * @param App\Classes\Pokemon $pokemon
    * @return void
    */
	public static function activate(Pokemon $pokemon): void
	{
		$pokemon->setSc('ScBide', 2, get_class());
	}

	/**
    * 固定ダメージ量の取得
    * @param args:array::mixed
    * @return integer
    */
    public static function getFixedDamage(...$args): int
    {
		/**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        * @param battle_state:object::BattleState バトル状態
        */
        list($atk, $def, $battle_state) = $args;
        // 攻撃ポケモンが、がまん中に受けたダメージの2倍のダメージを与える
        return $atk->getBideDamage() * 2;
    }

}
