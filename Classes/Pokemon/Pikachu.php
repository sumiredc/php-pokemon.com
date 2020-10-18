<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ピカチュウ
class Pikachu extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ピカチュウ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeElectric'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Raichu';

    /**
    * 初期レベル
    * @var array
    */
    protected $default_level = [
        5
    ];

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 112;

    /**
    * レベルアップで覚える技
    * @var array[習得レベル(integer), 技名称(class_name)]
    */
    protected $level_move = [
        [1, 'MoveThunderShock'],
        [1, 'MoveGrowl'],
        [9, 'MoveThunderWave'],
        [16, 'MoveQuickAttack'],
        [26, 'MoveSwift'],
        [33, 'MoveAgility'],
        [43, 'MoveThunder'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 35,
        'Attack' => 55,
        'Defense' => 40,
        'SpAtk' => 50,
        'SpDef' => 50,
        'Speed' => 90,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 2,
    ];

}
