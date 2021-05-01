<?php

require_once app_path('Classes/Pokemon.php');

// ゴローン
class Golone extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 75;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ゴローン';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'がんせきポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '崖を 登り 山頂を 目指す。 てっぺんに 着くなり すぐに 来た 山道を 転がり 落ちていく。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeRock', 'TypeGround'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 137;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 120;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 105.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],          # たいあたり
        [1, 'MoveDifenseCurl'],     # まるくなる
        [11, 'MoveDifenseCurl'],    # まるくなる
		[16, 'MoveRockThrow'],    	# いわおとし
		[21, 'MoveSelfDestruct'],   # じばく
		[29, 'MoveHarden'],    		# かたくなる
		[36, 'MoveEarthquake'],    	# じしん
		[43, 'MoveExplosion'],    	# だいばくはつ
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 55,
        'A' => 95,
        'B' => 115,
        'C' => 45,
        'D' => 45,
        'S' => 35,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'B' => 2,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public const BEFORE_CLASS = 'Ishitsubute';

	/**
    * 進化後（クラス名）
    * @var string
    */
    public const AFTER_CLASS = 'Golonya';

}
