<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ニャース
class Nyarth extends Pokemon
{

    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 52;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ニャース';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeNormal'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Persian';

    /**
    * 進化レベル
    * @var integer
    */
    protected $evolve_level = 28;

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 58;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 255;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 4.2;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
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
    protected $base_stats = [
        'HP' => 40,
        'Attack' => 45,
        'Defense' => 35,
        'SpAtk' => 40,
        'SpDef' => 40,
        'Speed' => 90,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 1,
    ];

}
