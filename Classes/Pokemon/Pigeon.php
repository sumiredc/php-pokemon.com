<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ピジョン
class Pigeon extends Pokemon
{
    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 17;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ピジョン';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeNormal', 'TypeFlying'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Poppo';

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Pigeot';

    /**
    * 進化レベル
    * @var integer
    */
    protected $evolve_level = 36;

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 122;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 120;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 30.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveGust'],            # かぜおこし
        [1, 'MoveSandAttack'],      # すなかけ
        [5, 'MoveSandAttack'],      # すなかけ
        [12, 'MoveQuickAttack'],    # でんこうせっか
        [21, 'MoveWhirlwind'],      # ふきとばし
        [31, 'MoveWingAttack'],     # つばさでうつ
        [40, 'MoveAgility'],        # こうそくいどう
        [49, 'MoveMirrorMove'],     # オウムがえし
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 63,
        'Attack' => 60,
        'Defense' => 55,
        'SpAtk' => 50,
        'SpDef' => 50,
        'Speed' => 71,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 2,
    ];

}
