<?php

require_once app_path('Classes/Pokemon.php');

// ピジョン
class Pigeon extends Pokemon
{
    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 17;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ピジョン';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'とりポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '広い 縄張りを 飛んで 見まわりを する。 縄張りを 荒らす 相手は 容赦 しない。 鋭い ツメで 徹底的に 懲らしめるぞ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeNormal', 'TypeFlying'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 36;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 122;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 120;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 30.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveGust'],            # かぜおこし
        [1, 'MoveSandAttack'],      # すなかけ
        [5, 'MoveSandAttack'],      # すなかけ
        [12, 'MoveQuickAttack'],    # でんこうせっか
        [21, 'MoveWhirlwind'],      # ふきとばし
        [31, 'MoveWingAttack'],     # つばさでうつ
        [40, 'MoveAgility'],        # こうそくいどう
        [49, 'MoveMirrorMove'],     # オウムがえし
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 63,
        'A' => 60,
        'B' => 55,
        'C' => 50,
        'D' => 50,
        'S' => 71,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'S' => 2,
    ];

    /**
    * 進化前（クラス名）
    * @var string
    */
    public const BEFORE_CLASS = 'Poppo';

    /**
    * 進化後（クラス名）
    * @var string
    */
    public const AFTER_CLASS = 'Pigeot';

}
