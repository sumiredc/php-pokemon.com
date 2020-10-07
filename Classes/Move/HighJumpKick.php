<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// とびひざげり
class HighJumpKick extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'とびひざげり';

    /**
    * 説明文
    * @var string
    */
    protected $description = '攻撃がはずれると自分最大HPの半分のダメージを受ける。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Fighting';

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
    protected $accuracy = 90;

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

    /**
    * 技の失敗
    *
    * @param object Pokemon $atk
    * @return void
    */
    public function failed($atk)
    {
        // 最大HPの1/2ダメージを受ける
        $atk->calRemainingHp('sub', $atk->getStats('HP') / 2);
        // メッセージをセット
        $this->setMessage('勢い余って'.$atk->getPrefixName().'は地面にぶつかった');
    }

}
