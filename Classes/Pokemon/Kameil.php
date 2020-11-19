<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// カメール
class Kameil extends Pokemon
{
    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 8;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'カメール';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeWater'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Zenigame';

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Kamex';

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
    * 捕捉率
    * @var integer
    */
    protected $capture = 45;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 22.5;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveTackle'],
        [1, 'MoveTailwhip'],
        [1, 'MoveBubble'],
        [8, 'MoveBubble'],
        [15, 'MoveWaterGun'],
        [24, 'MoveBite'],
        [31, 'MoveWithdraw'],
        [39, 'MoveSkullBash'],
        [47, 'MoveHydroPump'],
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 59,
        'Attack' => 63,
        'Defense' => 80,
        'SpAtk' => 65,
        'SpDef' => 80,
        'Speed' => 58,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Defense' => 1,
        'SpDef' => 1,
    ];

}
