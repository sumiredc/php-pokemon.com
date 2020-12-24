<?php

require_once(root_path('Classes').'Pokemon.php');

// カメックス
class Kamex extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 9;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'カメックス';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'こうらポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '精密な 射撃は 苦手。 31門の 大砲で 撃って撃って 撃ちまくる スタイルで 攻めるのだ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeWater'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 265;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 85.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],
        [1, 'MoveTailWhip'],
        [1, 'MoveWaterGun'],
        [1, 'MoveBubble'],
        [8, 'MoveBubble'],
        [15, 'MoveWaterGun'],
        [24, 'MoveBite'],
        [31, 'MoveWithdraw'],
        [42, 'MoveSkullBash'],
        [52, 'MoveHydroPump'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 79,
        'A' => 83,
        'B' => 100,
        'C' => 85,
        'D' => 105,
        'S' => 78,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'D' => 3,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public const BEFORE_CLASS = 'Kameil';

}
