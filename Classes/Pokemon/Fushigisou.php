<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// フシギソウ
class Fushigisou extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'フシギソウ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Grass', 'Poison'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Fushigidane';

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Fushigibana';

    /**
    * 初期レベル
    * @var array
    */
    protected $default_level = [
        16
    ];

    /**
    * 進化レベル
    * @var integer
    */
    protected $evolve_level = 32;

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 142;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'Tackle'],
        [1, 'Growl'],
        [1, 'LeechSeed'],
        [7, 'LeechSeed'],
        [13, 'VineWhip'],
        [22, 'PoisonPowder'],
        [30, 'RazorLeaf'],
        [38, 'Growth'],
        [46, 'SleepPowder'],
        [54, 'SolarBeam'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 60,
        'Attack' => 62,
        'Defense' => 63,
        'SpAtk' => 80,
        'SpDef' => 80,
        'Speed' => 60,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'SpAtk' => 1,
        'SpDef' => 1,
    ];

}
