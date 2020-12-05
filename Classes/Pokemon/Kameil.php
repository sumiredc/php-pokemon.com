<?php

require_once(root_path('Classes').'Pokemon.php');

// カメール
class Kameil extends Pokemon
{
    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 8;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'カメール';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'かめポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '長生きの シンボルと されている。 甲羅に 苔が ついているのは とくに 長生きの カメールだ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeWater'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 36;

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
    public const WEIGHT = 22.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],
        [1, 'MoveTailwhip'],
        [1, 'MoveBubble'],
        [8, 'MoveBubble'],
        [15, 'MoveWaterGun'],
        [24, 'MoveBite'],
        [31, 'MoveWithdraw'],
        [39, 'MoveSkullBash'],  # ロケットずつき
        [47, 'MoveHydroPump'],  # ハイドロポンプ
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 59,
        'A' => 63,
        'B' => 80,
        'C' => 65,
        'D' => 80,
        'S' => 58,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'B' => 1,
        'D' => 1,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public static $before_class = 'Zenigame';

    /**
    * 進化後（クラス名）
    * @var string
    */
    public static $after_class = 'Kamex';

}
