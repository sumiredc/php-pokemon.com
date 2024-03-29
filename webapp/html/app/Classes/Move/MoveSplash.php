<?php

require_once app_path('Classes/Move.php');

// はねる
class MoveSplash extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'はねる';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '効果なし。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
    */
    public const SPECIES = 'status';

    /**
    * 威力
    * @var integer
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 40;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'friend';

    /**
    * 追加効果
    *
    * @param args:array
    * @return void
    */
    public static function effects(...$args)
    {
        response()->setMessage('しかし、何も起こらない！');
    }

}
