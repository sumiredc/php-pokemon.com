<?php

require_once app_path('Classes/Pokemon.php');

// カブト
class Kabuto extends Pokemon
{

	/**
	* ポケモン全国図鑑ナンバー
	* @var integer
	*/
	public const NUMBER = 140;

	/**
	* 正式名称
	* @var string(min:1 max:5)
	*/
	public const NAME = 'カブト';

	/**
	* 分類
	* @var string
	*/
	public const SPECIES = 'こうらポケモン';

	/**
	* 説明文
	* @var string
	*/
	public const DESCRIPTION = 'ほぼ 全滅した ポケモン。 3日に 一度 脱皮して 殻を どんどん 硬くする。';

	/**
	* タイプ
	* @var array
	*/
	public const TYPES = ['TypeRock', 'TypeWater'];

	/**
	* 進化レベル
	* @var integer
	*/
	public const EVOLVE_LEVEL = 40;

	/**
	* 基礎経験値
	* @var integer
	*/
	public const BASE_EXP = 71;

	/**
	* 捕捉率
	* @var integer
	*/
	public const CAPTURE = 45;

	/**
	* 重さ
	* @var float
	*/
	public const WEIGHT = 11.5;

	/**
	* レベルアップで覚える技
	* @var array
	*/
	public const LEVEL_MOVE = [
		[1, 'MoveScratch'],         # ひっかく
		[1, 'MoveHarden'],    		# かたくなる
		[34, 'MoveAbsorb'],    		# すいとる
		[39, 'MoveSlash'],			# きりさく
		[44, 'MoveLeer'],    		# にらみつける
		[49, 'MoveHydroPump'],  	# ハイドロポンプ
	];

	/**
	* 種族値
	* @var array
	*/
	public const BASE_STATS = [
		'H' => 30,
		'A' => 80,
		'B' => 90,
		'C' => 55,
		'D' => 45,
		'S' => 55,
	];

	/**
	* 獲得努力値
	* @var array
	*/
	public const REWARD_EV = [
		'B' => 1,
	];

	/**
	* 進化後（クラス名）
	* @var string
	*/
	public const AFTER_CLASS = 'Kabutops';

}
