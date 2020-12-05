<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// コイキング
class Koiking extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 129;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'コイキング';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'さかなポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '力も スピードも ほとんどダメ。世界で 一番 弱くて 情けない ポケモンだ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeWater'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 20;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 40;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 255;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 10.0;

    /**
    * レベルアップで覚える技
    * @var array[習得レベル(integer), 技名称(class_name)]
    */
    public const LEVEL_MOVE = [
        [1, 'MoveSplash'],
        [15, 'MoveTackle'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 20,
        'A' => 10,
        'B' => 55,
        'C' => 15,
        'D' => 20,
        'S' => 80,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'S' => 2,
    ];

    /**
    * 進化後（クラス名）
    * @var string
    */
    public static $after_class = 'Gyarados';

}
