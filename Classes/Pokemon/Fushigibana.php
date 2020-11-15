<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// フシギバナ
class Fushigibana extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'フシギバナ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeGrass', 'TypePoison'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Fushigisou';

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 263;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveTackle'],
        [1, 'MoveGrowl'],
        [1, 'MoveLeechSeed'],
        [1, 'MoveVineWhip'],
        [7, 'MovePoisonPowder'],
        [13, 'MoveVineWhip'],
        [22, 'MovePoisonPowder'],
        [30, 'MoveRazorLeaf'],
        [43, 'MoveGrowth'],
        [55, 'MoveSleepPowder'],
        [65, 'MoveSolarBeam'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 80,
        'Attack' => 82,
        'Defense' => 83,
        'SpAtk' => 100,
        'SpDef' => 100,
        'Speed' => 80,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'SpAtk' => 2,
        'SpDef' => 1,
    ];

}
