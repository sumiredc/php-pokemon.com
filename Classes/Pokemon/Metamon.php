<?php
require_once(__DIR__.'/../Pokemon.php');

// メタモン
class Metamon extends Pokemon
{

    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 132;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = 'メタモン';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['TypeNormal'];

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 101;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 35;

    /**
    * 重さ
    * @var float
    */
    protected $weight = 4.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveTransform'],             # へんしん
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 48,
        'Attack' => 48,
        'Defense' => 48,
        'SpAtk' => 48,
        'SpDef' => 48,
        'Speed' => 48,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'HP' => 1,
    ];

}
