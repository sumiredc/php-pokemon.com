<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// フェアリータイプ
class TypeFairy extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'フェアリー';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeFighting', 'TypeDragon', 'TypeDark'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeFire', 'TypePoison', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
