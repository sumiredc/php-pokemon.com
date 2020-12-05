<?php

require_once(root_path('Classes').'Move.php');

// じわれ
class MoveFissure extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'じわれ';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '一撃必殺技';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGround';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 30;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 5;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 一撃必殺技確認用フラグ
    * @var boolean
    */
    public const ONE_HIT_KNOCKOUT_FLG = true;

}
