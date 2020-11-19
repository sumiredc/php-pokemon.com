<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Pokemon.php');

//
class PokemonStub extends Pokemon
{
    /**
    * ポケモンナンバー
    * @var integer
    */
    protected $number = 0;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    protected $name = '';

    /**
    * タイプ
    * @var array
    */
    protected $types = ['Type'];

    /**
    * 進化前（クラス名）
    * @var string
    */
    protected $before_class = '';

    /**
    * 進化後（クラス名）
    * @var string
    */
    protected $after_class = '';

    /**
    * 進化レベル
    * @var integer
    */
    protected $evolve_level = 00;

    /**
    * 基礎経験値
    * @var integer
    */
    protected $base_exp = 000;

    /**
    * 捕捉率
    * @var integer
    */
    protected $capture = 000;

    /**
    * 重さ
    * @var numeric
    */
    protected $weight = 0.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    protected $level_move = [
        [1, 'MoveTackle'],      # たいあたり
    ];

    /**
    * 種族値
    * @var array
    */
    protected $base_stats = [
        'HP' => 0,
        'Attack' => 0,
        'Defense' => 0,
        'SpAtk' => 0,
        'SpDef' => 0,
        'Speed' => 0,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    protected $reward_ev = [
        'HP' => 0,
    ];

}
