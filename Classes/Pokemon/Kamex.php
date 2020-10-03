<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// カメックス
class Kamex extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'カメックス';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Water'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Kameil';

    /**
    * 初期レベル
    * @var array
    */
    protected $default_level = [
        36
    ];

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 265;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'Tackle'],
        [1, 'TailWhip'],
        [1, 'WaterGun'],
        [1, 'Bubble'],
        [8, 'Bubble'],
        [15, 'WaterGun'],
        [24, 'Bite'],
        [31, 'Withdraw'],
        [42, 'SkullBash'],
        [52, 'HydroPump'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 79,
        'Attack' => 83,
        'Defense' => 100,
        'SpAtk' => 85,
        'SpDef' => 105,
        'Speed' => 78,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'SpDef' => 3,
    ];

}
