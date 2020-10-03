<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// リザードン
class Lizardon extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'リザードン';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Fire', 'Flying'];

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
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'Scratch'],
        [1, 'Growl'],
        [1, 'Growl'],
        [1, 'Ember'],
        [9, 'Ember'],
        [15, 'Leer'],
        [24, 'Rage'],
        [36, 'Slash'],
        [46, 'Flamethrower'],
        [55, 'FireSpin'],
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
