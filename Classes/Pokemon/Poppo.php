<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ポッポ
class Poppo extends Pokemon
{
    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 16;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ポッポ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'ことりポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '方向 感覚に とても 優れているので どんなに 離れた 場所からでも 迷わずに 自分の 巣 まで 帰る ことが できる。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeNormal', 'TypeFlying'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 18;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 50;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 255;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 1.8;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveGust'],            # かぜおこし
        [5, 'MoveSandAttack'],      # すなかけ
        [12, 'MoveQuickAttack'],    # でんこうせっか
        [19, 'MoveWhirlwind'],      # ふきとばし
        [28, 'MoveWingAttack'],     # つばさでうつ
        [36, 'MoveAgility'],        # こうそくいどう
        [44, 'MoveMirrorMove'],     # オウムがえし
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 40,
        'A' => 45,
        'B' => 40,
        'C' => 35,
        'D' => 35,
        'S' => 56,
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
    public static $after_class = 'Pigeon';

}
