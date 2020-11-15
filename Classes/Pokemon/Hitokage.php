<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ヒトカゲ
class Hitokage extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ヒトカゲ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeFire'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Lizardo';

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
        [1, 'MoveScratch'],
        [1, 'MoveGrowl'],
        [9, 'MoveEmber'],
        [15, 'MoveLeer'],
        [22, 'MoveRage'],
        [30, 'MoveSlash'],
        [38, 'MoveFlamethrower'],
        [46, 'MoveFireSpin'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 39,
        'Attack' => 52,
        'Defense' => 43,
        'SpAtk' => 60,
        'SpDef' => 50,
        'Speed' => 65,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 1,
    ];

}
