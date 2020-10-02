<?php
require_once(__DIR__.'/../Pokemon.php');

// ミュウ
class Mew extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ミュウ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Psychic'];

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
    protected $base_exp = 300;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'SkullBash'],
        [1, 'Struggle'],
        [1, 'LeechSeed'],
        [1, 'ConfuseRay'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 100,
        'Attack' => 100,
        'Defense' => 100,
        'SpAtk' => 100,
        'SpDef' => 100,
        'Speed' => 100,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'HP' => 3,
    ];

}
