<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// かみつく
class Bite extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'かみつく';

    /**
    * 説明文
    * @var string
    */
    protected $description = '30％の確率で敵をひるませる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Dark';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 60;

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
        // 30%の確率
        if(30 < random_int(0, 100)){
            // random_intで31以上が生成されたら失敗
            return;
        }
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手をひるませる
        $msg = $def->setSc('ScFlinch');
        // メッセージをセット
        $this->setMessage($msg);
    }

}
