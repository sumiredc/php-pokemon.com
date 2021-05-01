<?php

require_once app_path('Classes/Pokemon.php');

// イワーク
class Iwark extends Pokemon
{

    /**
    * ポケモン全国図鑑ナンバー
    * @var integer
    */
    public const NUMBER = 95;

    /**
    * 正式名称
    * @var string(min:1 max:5)
    */
    public const NAME = 'イワーク';

    /**
    * 分類
    * @var string
    */
    public const SPECIES = 'いわへびポケモン';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '地中を 掘り進みながら いろんな 硬いものを 取り込み 頑丈な 体をつくる。';

    /**
    * タイプ
    * @var array
    */
    public const TYPES = ['TypeRock', 'TypeGround'];

    /**
    * 基礎経験値
    * @var integer
    */
    public const BASE_EXP = 77;

    /**
    * 捕捉率
    * @var integer
    */
    public const CAPTURE = 45;

    /**
    * 重さ
    * @var float
    */
    public const WEIGHT = 210.0;

    /**
    * レベルアップで覚える技
    * @var array
    */
    public const LEVEL_MOVE = [
        [1, 'MoveTackle'],          # たいあたり
        [1, 'MoveScreech'],    		# いやなおと
		[15, 'MoveBind'],   		# しめつける
		[19, 'MoveRockThrow'],    	# いわおとし
		[25, 'MoveRage'],    		# いかり
		[33, 'MoveSlam'],    		# たたきつける
		[43, 'MoveHarden'],    		# かたくなる
    ];

    /**
    * 種族値
    * @var array
    */
    public const BASE_STATS = [
        'H' => 35,
        'A' => 45,
        'B' => 160,
        'C' => 30,
        'D' => 45,
        'S' => 70,
    ];

    /**
    * 獲得努力値
    * @var array
    */
    public const REWARD_EV = [
        'B' => 1,
    ];

}
