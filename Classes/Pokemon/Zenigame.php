<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ゼニガメ
class Zenigame extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ゼニガメ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Water'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Kameil';

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
    protected $base_exp = 63;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'Tackle'],
        [1, 'TailWhip'],
        [8, 'Bubble'],
        [15, 'WaterGun'],
        [22, 'Bite'],
        [28, 'Withdraw'],
        [35, 'SkullBash'],
        [42, 'HydroPump'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 44,
        'Attack' => 48,
        'Defense' => 65,
        'SpAtk' => 50,
        'SpDef' => 64,
        'Speed' => 43,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Defense' => 1,
    ];

}
