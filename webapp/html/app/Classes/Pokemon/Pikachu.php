<?php

require_once app_path('Classes/Pokemon.php');

/*
* ピカチュウ
*/
class Pikachu extends Pokemon
{

    //=====================================
    // オブジェクト定数
    //=====================================

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 25;

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ピカチュウ';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'ねずみポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = 'つくる 電気が 強力な ピカチュウほど ほっぺの 袋は 軟らかく よく 伸びるぞ。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeElectric'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 112;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 190;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 6.0;

    /**
    * レベルアップ技
    * @var array::[習得レベル:integer,技名称:string]
    */
    public const LEVEL_MOVE = [
        [1, 'MoveThunderShock'],
        [1, 'MoveGrowl'],
        [9, 'MoveThunderWave'],
        [16, 'MoveQuickAttack'],
        [26, 'MoveSwift'],
        [33, 'MoveAgility'],
        [43, 'MoveThunder'],
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 35,
        'A' => 55,
        'B' => 40,
        'C' => 50,
        'D' => 50,
        'S' => 90,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'S' => 2,
    ];

    /**
    * 進化先
    * @var string
    */
    public const AFTER_CLASS = 'Raichu';

    //=====================================
    // 専用メソッド
    //=====================================

    /**
    * 進化条件の分岐
    * @param args:array
    * @var boolean
    */
    public function judgeEvolve(...$args): bool
    {
        list($item) = $args;
        if($item === 'ItemThunderStone'){
            // 進化フラグを立てる
            $this->evolve_flg = true;
        }
        // 結果を返却
        return $this->evolve_flg;
    }

}
