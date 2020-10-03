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
    protected $types = ['Fire'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Lizardo';

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
    protected $base_exp = 64;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'Scratch'],
        [1, 'Growl'],
        [9, 'Ember'],
        [15, 'Leer'],
        [22, 'Rage'],
        [30, 'Slash'],
        [38, 'Flamethrower'],
        [46, 'FireSpin'],
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
