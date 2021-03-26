<?php

require_once app_path('Classes/Pokemon.php');

// フシギバナ
class Fushigibana extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 3;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'フシギバナ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'たねポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '2本の ふとい ツルを 振りまわし 戦う。 10階建ての ビルを かるく なぎ倒すほど パワフルだ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeGrass', 'TypePoison'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 263;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 100.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],
        [1, 'MoveGrowl'],
        [1, 'MoveLeechSeed'],
        [1, 'MoveVineWhip'],
        [7, 'MovePoisonPowder'],
        [13, 'MoveVineWhip'],
        [22, 'MovePoisonPowder'],
        [30, 'MoveRazorLeaf'],
        [43, 'MoveGrowth'],
        [55, 'MoveSleepPowder'],
        [65, 'MoveSolarBeam'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 80,
        'A' => 82,
        'B' => 83,
        'C' => 100,
        'D' => 100,
        'S' => 80,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'C' => 2,
        'D' => 1,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public const BEFORE_CLASS = 'Fushigisou';

}
