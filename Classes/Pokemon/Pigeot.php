<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ピジョット
class Pigeot extends Pokemon
{
    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 18;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ピジョット';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeNormal', 'TypeFlying'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Pigeon';

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 172;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 45;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 39.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveGust'],            # かぜおこし
        [1, 'MoveSandAttack'],      # すなかけ
        [1, 'MoveQuickAttack'],     # でんこうせっか
        [5, 'MoveSandAttack'],      # すなかけ
        [12, 'MoveQuickAttack'],    # でんこうせっか
        [21, 'MoveWhirlwind'],      # ふきとばし
        [31, 'MoveWingAttack'],     # つばさでうつ
        [44, 'MoveAgility'],        # こうそくいどう
        [54, 'MoveMirrorMove'],     # オウムがえし
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 83,
        'Attack' => 80,
        'Defense' => 75,
        'SpAtk' => 70,
        'SpDef' => 70,
        'Speed' => 101,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 3,
    ];

}
