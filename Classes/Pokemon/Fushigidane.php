<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// フシギダネ
class Fushigidane extends Pokemon
{

    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 1;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'フシギダネ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeGrass', 'TypePoison'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Fushigisou';

    /**
    * 進化レベル
    * @var integer
    */
    protected $evolve_level = 16;

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 64;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 45;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 6.9;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveTackle'],          # たいあたり
        [1, 'MoveGrowl'],           # なきごえ
        [7, 'MoveLeechSeed'],       # やどりぎのタネ
        [13, 'MoveVineWhip'],       # つるのムチ
        [20, 'MovePoisonPowder'],   # どくのこな
        [27, 'MoveRazorLeaf'],      # はっぱカッター
        [34, 'MoveGrowth'],         # せいちょう
        [41, 'MoveSleepPowder'],    # ねむりごな
        [48, 'MoveSolarBeam'],      # ソーラービーム
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 45,
        'Attack' => 49,
        'Defense' => 49,
        'SpAtk' => 65,
        'SpDef' => 65,
        'Speed' => 45,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'SpAtk' => 1,
    ];

}
