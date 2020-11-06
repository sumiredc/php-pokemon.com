<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ライチュウ
class Raichu extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ライチュウ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeElectric'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Pikachu';

    /**
    * 初期レベル
    * @var array
    */
    protected $default_level = [
        55, 56, 57,
    ];

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 243;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        // テスト技
        // [1, 'MoveThunder'], # かみなり
        // [1, 'MoveTailWhip'], # しっぽをふる
        // [1, 'MoveCounter'], # カウンター
        [1, 'MoveThrash'], # あばれる

        // 本技
        // [1, 'MoveThunderShock'],
        // [1, 'MoveGrowl'],
        // [9, 'MoveThunderWave'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 60,
        'Attack' => 90,
        'Defense' => 55,
        'SpAtk' => 90,
        'SpDef' => 80,
        'Speed' => 110,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 3,
    ];

}
