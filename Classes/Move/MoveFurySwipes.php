<?php

require_once(root_path('Classes').'Move.php');

// みだれひっかき
class MoveFurySwipes extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'みだれひっかき';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '2〜5回連続で攻撃する';

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
    public const POWER = 18;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 80;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 15;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 連続攻撃回数
    *
    * @return integer
    */
    public static function times(): int
    {
        return random_int(2, 5);
    }

}
