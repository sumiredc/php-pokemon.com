<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ゼニガメ
class Zenigame extends Pokemon
{

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ゼニガメ';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeWater'];

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = 'Kameil';

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
    protected $base_exp = 63;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveTackle'],      # たいあたり
        [1, 'MoveTailWhip'],    # しっぽをふる
        [8, 'MoveBubble'],      # あわ
        [15, 'MoveWaterGun'],   # みずてっぽう
        [22, 'MoveBite'],       # かみつく
        [28, 'MoveWithdraw'],   # からにこもる
        [35, 'MoveSkullBash'],  # ロケットずつき
        [42, 'MoveHydroPump'],  # ハイドロポンプ
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 44,
        'Attack' => 48,
        'Defense' => 65,
        'SpAtk' => 50,
        'SpDef' => 64,
        'Speed' => 43,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Defense' => 1,
    ];

}
