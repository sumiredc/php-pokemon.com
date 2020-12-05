<?php

require_once(root_path('Classes').'Pokemon.php');

// ピジョット
class Pigeot extends Pokemon
{
    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 18;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ピジョット';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'とりポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '美しい 光沢の 羽を 持つ ポケモン。 頭の 羽の 美しさに 心 奪われ ピジョットを 育てる トレーナーも 多い。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeNormal', 'TypeFlying'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 172;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 39.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveGust'],            # かぜおこし
        [1, 'MoveSandAttack'],      # すなかけ
        [1, 'MoveQuickAttack'],     # でんこうせっか
        [5, 'MoveSandAttack'],      # すなかけ
        [12, 'MoveQuickAttack'],    # でんこうせっか
        [21, 'MoveWhirlwind'],      # ふきとばし
        [31, 'MoveWingAttack'],     # つばさでうつ
        [44, 'MoveAgility'],        # こうそくいどう
        [54, 'MoveMirrorMove'],     # オウムがえし
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 83,
        'A' => 80,
        'B' => 75,
        'C' => 70,
        'D' => 70,
        'S' => 101,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'S' => 3,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public static $before_class = 'Pigeon';

}
