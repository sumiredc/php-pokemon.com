<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// コイキング
class Koiking extends Pokemon
{

    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 129;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'コイキング';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeWater'];

    /**
    * 進化レベル
    * @var integer
    */
    protected $evolve_level = 20;

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Gyarados';

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 40;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 255;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 10.0;

    /**
    * レベルアップで覚える技
    * @var array[習得レベル(integer), 技名称(class_name)]
    */
    protected $level_move = [
        [1, 'MoveSplash'],
        [15, 'MoveTackle'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 20,
        'Attack' => 10,
        'Defense' => 55,
        'SpAtk' => 15,
        'SpDef' => 20,
        'Speed' => 80,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 2,
    ];

}
