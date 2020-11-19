<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// リザードン
class Lizardon extends Pokemon
{

    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 6;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'リザードン';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeFire', 'TypeFlying'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Lizardo';

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
    protected $base_exp = 267;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 45;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 90.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveScratch'],
        [1, 'MoveGrowl'],
        [1, 'MoveGrowl'],
        [1, 'MoveEmber'],
        [9, 'MoveEmber'],
        [15, 'MoveLeer'],
        [24, 'MoveRage'],
        [36, 'MoveSlash'],          # きりさく
        [46, 'MoveFlamethrower'],
        [55, 'MoveFireSpin'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 78,
        'Attack' => 84,
        'Defense' => 78,
        'SpAtk' => 109,
        'SpDef' => 85,
        'Speed' => 100,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'SpAtk' => 3,
    ];

}
