<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// カメール
class Kameil extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'カメール';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Water'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Zenigame';

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Kamex';

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
    protected $evolve_level = 36;

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
        [1, 'Tailwhip'],
        [1, 'Bubble'],
        [8, 'Bubble'],
        [15, 'WaterGun'],
        [24, 'Bite'],
        [31, 'Withdraw'],
        [39, 'SkullBash'],
        [47, 'HydroPump'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 59,
        'Attack' => 63,
        'Defense' => 80,
        'SpAtk' => 65,
        'SpDef' => 80,
        'Speed' => 58,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Defense' => 1,
        'SpDef' => 1,
    ];

}
