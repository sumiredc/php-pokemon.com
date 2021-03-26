<?php
require_once(__DIR__.'/../Pokemon.php');

// メタモン
class Metamon extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 132;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'メタモン';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'へんしんポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '全身の 細胞を 組み替えて 見たもの そっくりに 変身するが 力が 抜けると もとにもどる。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeNormal'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 101;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 35;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 4.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTransform'],             # へんしん
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 48,
        'A' => 48,
        'B' => 48,
        'C' => 48,
        'D' => 48,
        'S' => 48,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'H' => 1,
    ];

}
