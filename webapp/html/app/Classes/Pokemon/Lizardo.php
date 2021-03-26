<?php

require_once app_path('Classes/Pokemon.php');

// リザード
class Lizardo extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 5;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'リザード';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'かえんポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '燃える しっぽを 振りまわし するどい ツメで 相手を 切り裂く 荒々しい 性格。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeFire'];

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
    public const WEIGHT = 19.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveScratch'],
        [1, 'MoveGrowl'],
        [1, 'MoveEmber'],
        [9, 'MoveEmber'],
        [15, 'MoveLeer'],
        [24, 'MoveRage'],
        [33, 'MoveSlash'],
        [42, 'MoveFlamethrower'],
        [56, 'MoveFireSpin'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 58,
        'A' => 64,
        'B' => 58,
        'C' => 80,
        'D' => 65,
        'S' => 80,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'C' => 1,
        'S' => 1,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public const BEFORE_CLASS = 'Hitokage';

    /**
    * 進化後（クラス名）
    * @var string
    */
    public const AFTER_CLASS = 'Lizardon';

}
