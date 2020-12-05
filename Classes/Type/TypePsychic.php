<?php

require_once(root_path('Classes').'Type.php');

// エスパータイプ
class TypePsychic extends Type
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'エスパー';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    public const EXCELLENT = ['TypeFighting', 'TypePoison'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    public const NOT_VERY = ['TypePshchic', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    public const DOESNT_AFFECT = ['TypeDark'];

}
