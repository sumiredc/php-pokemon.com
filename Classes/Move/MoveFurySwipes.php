<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// みだれひっかき
class MoveFurySwipes extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'みだれひっかき';

    /**
    * 説明文
    * @var string
    */
    protected $description = '2〜5回連続で攻撃する';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 18;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 80;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 15;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * 連続攻撃回数
    *
    * @return integer
    */
    public function times()
    {
        return random_int(2, 5);
    }

}
