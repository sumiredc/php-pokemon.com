<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Type.php');

// ゴーストタイプ
class TypeGhost extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ゴースト';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['TypePsychic', 'TypeGhost'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['TypeDark'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['TypeNormal'];

}
