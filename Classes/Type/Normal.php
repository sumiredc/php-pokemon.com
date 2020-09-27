<?php
require_once(__DIR__.'/../Type.php');

// ノーマルタイプ
class Normal extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ノーマル';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = [];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Rock', 'Steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = ['Ghost'];

}
