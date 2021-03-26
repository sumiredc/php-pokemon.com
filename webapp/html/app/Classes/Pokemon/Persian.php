<?php

require_once app_path('Classes/Pokemon.php');

// ペルシアン
class Persian extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 53;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'ペルシアン';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'シャムネコポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '気位が 高く なつかせるのは たいへん。 気に食わない ことが あると すぐに ツメを 立ててくる。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeNormal'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 154;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 90;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 32.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveScratch'],     # ひっかく
        [1, 'MoveBite'],        # かみつく
        [1, 'MoveGrowl'],       # なきごえ
        [1, 'MoveScreech'],     # いやなおと
        [12, 'MoveBite'],       # かみつく
        [17, 'MovePayDay'],     # ネコにこばん
        [24, 'MoveScreech'],    # いやなおと
        [37, 'MoveFurySwipes'], # みだれひっかき
        [51, 'MoveSlash'],      # きりさく
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 65,
        'A' => 70,
        'B' => 60,
        'C' => 65,
        'D' => 65,
        'S' => 115,
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
    public const BEFORE_CLASS = 'Nyarth';

}
