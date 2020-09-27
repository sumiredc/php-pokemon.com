<?php
require_once(__DIR__.'/../Type.php');

// ゴーストタイプ
class Ghost extends Type
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
    protected $excellent = ['Psychic', 'Ghost'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Dark'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Normal'];

}
