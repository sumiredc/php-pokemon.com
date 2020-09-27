<?php
require_once(__DIR__.'/../Move.php');

//
class 000 extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = '';

    /**
    * 説明文
    * @var string
    */
    protected $description = '';

    /**
    * タイプ
    * @var string
    */
    protected $type = '';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = '';

    /**
    * 威力
    * @var integer
    */
    protected $power = ;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = ;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = ;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = ;

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
        //
        $msg = ;
        $this->setMessage($msg);
    }

}
