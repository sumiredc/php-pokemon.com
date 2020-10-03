<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// やどりぎのタネ
class LeechSeed extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'やどりぎのタネ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手をやどりぎのタネ状態にし、毎ターン相手の最大HPの1/8を奪って、その分自分のHPを回復を回復させる。自分が交代しても効果は続く。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Grass';

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
        // 相手をやどりぎのタネ状態にする
        $msg = $def->setSc('ScLeechSeed');
        $this->setMessage($msg);
    }

}
