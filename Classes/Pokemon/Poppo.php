<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ポッポ
class Poppo extends Pokemon
{
    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 16;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ポッポ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeNormal', 'TypeFlying'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Pigeon';

    /**
    * 進化レベル
    * @var integer
    */
    protected $evolve_level = 18;

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 50;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 255;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 1.8;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveGust'],            # かぜおこし
        [5, 'MoveSandAttack'],      # すなかけ
        [12, 'MoveQuickAttack'],    # でんこうせっか
        [19, 'MoveWhirlwind'],      # ふきとばし
        [28, 'MoveWingAttack'],     # つばさでうつ
        [36, 'MoveAgility'],        # こうそくいどう
        [44, 'MoveMirrorMove'],     # オウムがえし
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 40,
        'Attack' => 45,
        'Defense' => 40,
        'SpAtk' => 35,
        'SpDef' => 35,
        'Speed' => 56,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 1,
    ];

}
