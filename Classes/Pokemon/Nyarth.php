<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ニャース
class Nyarth extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 52;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ニャース';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'ばけねこポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '光り物を 集めるのが 好き。 機嫌が いいときは トレーナーにも コレクションを 見せてくれるぞ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeNormal'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 28;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 58;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 255;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 4.2;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveScratch'],     # ひっかく
        [1, 'MoveGrowl'],       # なきごえ
        [12, 'MoveBite'],       # かみつく
        [17, 'MovePayDay'],     # ネコにこばん
        [24, 'MoveScreech'],    # いやなおと
        [33, 'MoveFurySwipes'], # みだれひっかき
        [44, 'MoveSlash'],      # きりさく
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 40,
        'A' => 45,
        'B' => 35,
        'C' => 40,
        'D' => 40,
        'S' => 90,
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
    public static $after_class = 'Persian';

}
