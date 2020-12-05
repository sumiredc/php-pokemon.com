<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// リザードン
class Lizardon extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 6;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'リザードン';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'かえんポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '岩石も 焼けるような 灼熱の 炎を 吐いて 山火事を 起こすことが ある。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeFire', 'TypeFlying'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 267;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 90.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveScratch'],
        [1, 'MoveGrowl'],
        [1, 'MoveGrowl'],
        [1, 'MoveEmber'],
        [9, 'MoveEmber'],
        [15, 'MoveLeer'],
        [24, 'MoveRage'],
        [36, 'MoveSlash'],          # きりさく
        [46, 'MoveFlamethrower'],
        [55, 'MoveFireSpin'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 78,
        'A' => 84,
        'B' => 78,
        'C' => 109,
        'D' => 85,
        'S' => 100,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'C' => 3,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public static $before_class = 'Lizardo';

}
