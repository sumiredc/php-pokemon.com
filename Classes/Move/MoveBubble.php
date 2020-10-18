<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// あわ
class MoveBubble extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'あわ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '10%の確率ですばやさを1段階下げる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeWater';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 40;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 30;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

    /**
    * 能力下降効果
    *
    * @param array $args
    * @return void
    */
    public function debuff(...$args)
    {
        // 10%の確率
        if(10 < random_int(1, 100)){
            // random_intで11以上が生成されたら失敗
            return;
        }
        /**
        * @param Pokemon:object $atk 攻撃ポケモン
        * @param Pokemon:object $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手の素早さランクを1段階下げる
        $msg = $def->subRank('Speed', 1);
        // メッセージをセット
        $this->setMessage($msg);
    }

}
