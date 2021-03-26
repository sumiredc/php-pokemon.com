<?php

require_once app_path('Classes/Pokemon.php');

// フシギソウ
class Fushigisou extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 2;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'フシギソウ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'たねポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '背中の つぼみが 大きく 育ってくると 2本脚で 立つことが できなくなるらしい。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeGrass', 'TypePoison'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 32;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 142;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 13.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],
        [1, 'MoveGrowl'],
        [1, 'MoveLeechSeed'],
        [7, 'MoveLeechSeed'],
        [13, 'MoveVineWhip'],
        [22, 'MovePoisonPowder'],
        [30, 'MoveRazorLeaf'],
        [38, 'MoveGrowth'],
        [46, 'MoveSleepPowder'],
        [54, 'MoveSolarBeam'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 60,
        'A' => 62,
        'B' => 63,
        'C' => 80,
        'D' => 80,
        'S' => 60,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'C' => 1,
        'D' => 1,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public const BEFORE_CLASS = 'Fushigidane';

    /**
    * 進化後（クラス名）
    * @var string
    */
    public const AFTER_CLASS = 'Fushigibana';

}
