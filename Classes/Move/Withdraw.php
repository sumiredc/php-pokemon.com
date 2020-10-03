<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// からにこもる
class Withdraw extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'からにこもる';

    /**
    * 説明文
    * @var string
    */
    protected $description = '自分のぼうぎょを1段階上げる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Water';

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
    protected $accuracy = null;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 40;

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
        // 自分の防御ランクを1段階上げる
        $msg = $atk->addRank('Defense', 1);
        // メッセージをセット
        $this->setMessage($msg);
    }

}
