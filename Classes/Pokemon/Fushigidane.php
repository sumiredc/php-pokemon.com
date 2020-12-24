<?php

require_once(root_path('Classes').'Pokemon.php');

// フシギダネ
class Fushigidane extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 1;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'フシギダネ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'たねポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '生まれたときから 背中に 植物の タネが あって 少しずつ 大きく 育つ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeGrass', 'TypePoison'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 16;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 64;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 6.9;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],          # たいあたり
        [1, 'MoveGrowl'],           # なきごえ
        [7, 'MoveLeechSeed'],       # やどりぎのタネ
        [13, 'MoveVineWhip'],       # つるのムチ
        [20, 'MovePoisonPowder'],   # どくのこな
        [27, 'MoveRazorLeaf'],      # はっぱカッター
        [34, 'MoveGrowth'],         # せいちょう
        [41, 'MoveSleepPowder'],    # ねむりごな
        [48, 'MoveSolarBeam'],      # ソーラービーム
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 45,
        'A' => 49,
        'B' => 49,
        'C' => 65,
        'D' => 65,
        'S' => 45,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'C' => 1,
    ];

    /**
    * 進化後（クラス名）
    * @var string
    */
    public const AFTER_CLASS = 'Fushigisou';

}
