<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// すなかけ
class SandAttack extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'すなかけ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手の命中率を1段階下げる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Ground';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'status';

    /**
    * 威力
    * @var integer
    */
    protected $power = null;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 15;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

    /**
    * 追加効果
    *
    * @param array $args
    * @return void
    */
    public function effects(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手の命中ランクを1段階下げる
        $msg = $def->subRank('Accuracy', 1);;
        $this->setMessage($msg);
    }

}
