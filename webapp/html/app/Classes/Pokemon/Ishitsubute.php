<?php

require_once app_path('Classes/Pokemon.php');

// イシツブテ
class Ishitsubute extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 74;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'イシツブテ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'がんせきポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '長く 生きた イシツブテは 角が とれて まんまる。 性格も とても 落ち着いていて 穏やか なのだ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeRock', 'TypeGround'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 25;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 60;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 255;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 20.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],          # たいあたり
        [11, 'MoveDifenseCurl'],    # まるくなる
		[16, 'MoveRockThrow'],    	# いわおとし
		[21, 'MoveSelfDestruct'],   # じばく
		[26, 'MoveHarden'],    		# かたくなる
		[31, 'MoveEarthquake'],    	# じしん
		[36, 'MoveExplosion'],    	# だいばくはつ
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 40,
        'A' => 80,
        'B' => 100,
        'C' => 30,
        'D' => 30,
        'S' => 20,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'B' => 1,
    ];

    /**
    * 進化後（クラス名）
    * @var string
    */
    public const AFTER_CLASS = 'Golone';

}
