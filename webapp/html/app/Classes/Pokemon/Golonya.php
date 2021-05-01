<?php

require_once app_path('Classes/Pokemon.php');

// ゴローニャ
class Golonya extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 76;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ゴローニャ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'メガトンポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'ダイナマイトで 爆破 しても 傷ひとつ つかない 身体 だが 湿気や 雨は 大嫌い。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeRock', 'TypeGround'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 233;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 300.0;

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
        'H' => 80,
        'A' => 120,
        'B' => 130,
        'C' => 55,
        'D' => 65,
        'S' => 45,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'B' => 3,
    ];

    /**
    * 進化後（クラス名）
    * @var string
    */
    public const BEFORE_CLASS = 'Golone';

}
