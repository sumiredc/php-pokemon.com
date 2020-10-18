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
    protected $types = ['TypeWater'];

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
        [1, 'MoveTackle'],
        [1, 'MoveTailWhip'],
        [1, 'MoveWaterGun'],
        [1, 'MoveBubble'],
        [8, 'MoveBubble'],
        [15, 'MoveWaterGun'],
        [24, 'MoveBite'],
        [31, 'MoveWithdraw'],
        [42, 'MoveSkullBash'],
        [52, 'MoveHydroPump'],
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
