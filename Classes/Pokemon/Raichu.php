<?php

require_once(root_path('Classes').'Pokemon.php');

// ライチュウ
class Raichu extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 26;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ライチュウ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'ねずみポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '長い しっぽが アースになって 身を 守るため 自分自身は 高電圧にも 痺れないのだ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeElectric'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 243;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 75;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 30.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        // 本技
        [1, 'MoveThunderShock'],
        [1, 'MoveGrowl'],
        [9, 'MoveThunderWave'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 60,
        'A' => 90,
        'B' => 55,
        'C' => 90,
        'D' => 80,
        'S' => 110,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'S' => 3,
    ];


    /**
    * 進化前（クラス名）
    * @var string
    */
    public static $before_class = 'Pikachu';

}
