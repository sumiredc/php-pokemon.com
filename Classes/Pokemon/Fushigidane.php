<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// フシギダネ
class Fushigidane extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'フシギダネ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Grass', 'Poison'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Fushigisou';

    /**
    * 初期レベル
    * @var array
    */
    protected $default_level = [
        5
    ];

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
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'Tackle'],
        [1, 'Growl'],
        [7, 'LeechSeed'],
        [13, 'VineWhip'],
        [20, 'PoisonPowder'],
        [27, 'RazorLeaf'],
        [34, 'Growth'],
        [41, 'SleepPowder'],
        [48, 'SolarBeam'],
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
