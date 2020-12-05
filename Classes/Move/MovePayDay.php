<?php

require_once(root_path('Classes').'Move.php');

// ネコにこばん
class MovePayDay extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ネコにこばん';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '戦いが終わったらお金を拾える。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 40;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 20;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * ネコにこばんの特別処理
    * @param atk:object::Pokemon
    * @return integer
    */
    public static function exPayDay($atk)
    {
        // レベル x 5円をセット
        return $atk->getLevel() * 5;
    }

}
