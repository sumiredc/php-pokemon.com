<?php

require_once app_path('Classes/Pokemon.php');

// カブトプス
class Kabutops extends Pokemon
{

	/**
	* ポケモン全国図鑑ナンバー
	* @var integer
	*/
	public const NUMBER = 141;

	/**
	* 正式名称
	* @var string(min:1 max:5)
	*/
	public const NAME = 'カブトプス';

	/**
	* 分類
	* @var string
	*/
	public const SPECIES = 'こうらポケモン';

	/**
	* 説明文
	* @var string
	*/
	public const DESCRIPTION = '獲物を 切り裂き 体液を すする。 残った 体は ほかのポケモンの エサになる。';

	/**
	* タイプ
	* @var array
	*/
	public const TYPES = ['TypeRock', 'TypeWater'];

	/**
	* 基礎経験値
	* @var integer
	*/
	public const BASE_EXP = 173;

	/**
	* 捕捉率
	* @var integer
	*/
	public const CAPTURE = 45;

	/**
	* 重さ
	* @var float
	*/
	public const WEIGHT = 40.5;

	/**
	* レベルアップで覚える技
	* @var array
	*/
	public const LEVEL_MOVE = [
		[1, 'MoveScratch'],         # ひっかく
		[1, 'MoveHarden'],    		# かたくなる
		[34, 'MoveAbsorb'],    		# すいとる
		[39, 'MoveSlash'],			# きりさく
		[46, 'MoveLeer'],    		# にらみつける
		[53, 'MoveHydroPump'],  	# ハイドロポンプ
	];

	/**
	* 種族値
	* @var array
	*/
	public const BASE_STATS = [
		'H' => 60,
		'A' => 115,
		'B' => 105,
		'C' => 65,
		'D' => 70,
		'S' => 80,
	];

	/**
	* 獲得努力値
	* @var array
	*/
	public const REWARD_EV = [
		'A' => 2,
	];

}
