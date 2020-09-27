<?php
require_once(__DIR__.'/../Move.php');

// ロケットずつき
class SkullBash extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ロケットずつき';

    /**
    * 説明文
    * @var string
    */
    protected $description = '1ターン目は準備し、2ターン目に攻撃する。準備ターンに自分の防御が1段階上がる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Normal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 130;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 10;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

}
