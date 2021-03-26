<?php

require_once app_path('Classes/Pokemon.php');

// ヒトカゲ
class Hitokage extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 4;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ヒトカゲ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'とかげポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '熱いものを 好む 性格。 雨に濡れると しっぽの 先から 煙が 出るという。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeFire'];

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
    public const WEIGHT = 8.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveScratch'],
        [1, 'MoveGrowl'],
        [9, 'MoveEmber'],
        [15, 'MoveLeer'],
        [22, 'MoveRage'],
        [30, 'MoveSlash'],
        [38, 'MoveFlamethrower'],
        [46, 'MoveFireSpin'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 39,
        'A' => 52,
        'B' => 43,
        'C' => 60,
        'D' => 50,
        'S' => 65,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'S' => 1,
    ];

    /**
    * 進化後（クラス名）
    * @var string
    */
    public const AFTER_CLASS = 'Lizardo';

}
