<?php

require_once app_path('Classes/Move.php');

// すいとる
class MoveAbsorb extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'すいとる';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手に与えたダメージの1/2だけHPを回復する。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGrass';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 20;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 25;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

	/**
	* 追加効果
	* @param args:array
	* @return void
	*/
	public static function effects(...$args)
	{
		/**
		* @param App\Classes\Pokemon $atk 攻撃ポケモン
		* @param App\Classes\Pokemon $def 防御ポケモン
		* @param integer $damage
		*/
		list($atk, $def, $damage) = $args;
		// 相手に与えたダメージの1/2回復
		return [
			'message' => $atk->getPrefixName().'は'.$def->getPrefixName().'から、体力を吸い取った',
			'heal' => (int)($damage / 2)
		];
	}

}
