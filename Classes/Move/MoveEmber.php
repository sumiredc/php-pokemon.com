<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ひのこ
class MoveEmber extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ひのこ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '10％の確率で相手をやけど状態にする。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeFire';

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
    protected $pp = 25;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

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
        // 相手が状態異常にかかっていない
        // 10%の確率
        if($def->getSa() || 10 < random_int(1, 100)){
            return;
        }
        // 相手をやけど状態にする
        $msg = $def->setSa('SaBurn');
        // メッセージをセット
        $this->setMessage($msg);
    }

}
