<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

// ペルシアン
class Persian extends Pokemon
{

    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 53;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'ペルシアン';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeNormal'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = 'Nyarth';

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 154;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 90;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 32.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveScratch'],     # ひっかく
        [1, 'MoveBite'],        # かみつく
        [1, 'MoveGrowl'],       # なきごえ
        [1, 'MoveScreech'],     # いやなおと
        [12, 'MoveBite'],       # かみつく
        [17, 'MovePayDay'],     # ネコにこばん
        [24, 'MoveScreech'],    # いやなおと
        [37, 'MoveFurySwipes'], # みだれひっかき
        [51, 'MoveSlash'],      # きりさく
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 65,
        'Attack' => 70,
        'Defense' => 60,
        'SpAtk' => 65,
        'SpDef' => 65,
        'Speed' => 115,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'Speed' => 2,
    ];

}
