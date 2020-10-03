<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// リザード
class Lizardo extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'リザード';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Fire'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Hitokage';

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Lizardon';

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
        [1, 'Scratch'],
        [1, 'Growl'],
        [1, 'Ember'],
        [9, 'Ember'],
        [15, 'Leer'],
        [24, 'Rage'],
        [33, 'Slash'],
        [42, 'Flamethrower'],
        [56, 'FireSpin'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 58,
        'Attack' => 64,
        'Defense' => 58,
        'SpAtk' => 80,
        'SpDef' => 65,
        'Speed' => 80,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'SpAtk' => 1,
        'Speed' => 1,
    ];

}
