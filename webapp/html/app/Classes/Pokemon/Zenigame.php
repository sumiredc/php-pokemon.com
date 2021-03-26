<?php

require_once app_path('Classes/Pokemon.php');

// ゼニガメ
class Zenigame extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 7;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ゼニガメ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'かめのこポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '長い 首を 甲羅のなかに 引っこめるとき 勢いよく 水鉄砲を 発射する。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeWater'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 16;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 63;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 9.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],      # たいあたり
        [1, 'MoveTailWhip'],    # しっぽをふる
        [8, 'MoveBubble'],      # あわ
        [15, 'MoveWaterGun'],   # みずてっぽう
        [22, 'MoveBite'],       # かみつく
        [28, 'MoveWithdraw'],   # からにこもる
        [35, 'MoveSkullBash'],  # ロケットずつき
        [42, 'MoveHydroPump'],  # ハイドロポンプ
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 44,
        'A' => 48,
        'B' => 65,
        'C' => 50,
        'D' => 64,
        'S' => 43,
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
    public const AFTER_CLASS = 'Kameil';

}
