<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// あやしいひかり
class ConfuseRay extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'あやしいひかり';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手をこんらん状態にする。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Ghost';

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
    protected $pp = 10;

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
        // 相手をこんらん状態にする
        $msg = $def->setSc('ScConfusion', random_int(1, 4));
        // メッセージをセット
        $this->setMessage($msg);
    }

}
