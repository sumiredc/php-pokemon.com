<?php
require_once(__DIR__.'/../Type.php');

// エスパータイプ
class Psychic extends Type
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
    protected $excellent = ['Fighting', 'Poison'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Pshchic', 'Steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Dark'];

}
