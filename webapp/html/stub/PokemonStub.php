<?php
require_once app_path('Classes/Pokemon.php');

/*
*
*/
class PokemonStub extends Pokemon
{

    //=====================================
    // オブジェクト定数
    //=====================================

    /**
    * 全国図鑑ナンバー
    * @var integer
    */
    public const number = 0;

    /**
    * 正式名称
    * @var string::min:1|max:5
    */
    public const NAME = '';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'ポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['Type'];

    /**
    * 進化レベル
    * @var integer
    */
    public const EVOLVE_LEVEL = 00;

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 0;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 000;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 0.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],      # たいあたり
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 0,
        'A' => 0,
        'B' => 0,
        'C' => 0,
        'D' => 0,
        'S' => 0,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWORD_EV = [
        'H' => 0,
    ];

    /**
    * 進化前のクラス
    * @var string
    */
    public const BEFORE_CLASS = '';

    /**
    * 進化後のクラス
    * @var string
    */
    public const AFTER_CLASS = '';

}
