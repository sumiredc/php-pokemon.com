<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// どくのこな
class PoisonPowder extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'どくのこな';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手をどく状態にする。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Poison';

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
    protected $accuracy = 75;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 35;

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
        // 相手をどく状態にする
        $msg = $def->setSa('SaPoison');
        // メッセージをセット
        $this->setMessage($msg);
    }

}
