<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// エスパータイプ
class TypePsychic extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'エスパー';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypeFighting', 'TypePoison'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypePshchic', 'TypeSteel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['TypeDark'];

}
