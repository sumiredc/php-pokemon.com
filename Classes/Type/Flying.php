<?php
require_once(__DIR__.'/../Type.php');

// ひこうタイプ
class Flying extends Type
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ひこう';

    /**
    * 攻撃技で使用したときの判定
    */

    /**
    * こうかばつぐん
    * @var integer
    */
    protected $excellent = ['Grass', 'Fighting', 'Bug'];

    /**
    * こうかいまひとつ
    * @var integer
    */
    protected $not_very = ['Electric', 'Rock', 'steel'];

    /**
    * こうかがない
    * @var integer
    */
    protected $doesnt_affect = [];

}
