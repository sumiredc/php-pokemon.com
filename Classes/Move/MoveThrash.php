<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// あばれる
class MoveThrash extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'あばれる';

    /**
    * 説明文
    * @var string
    */
    protected $description = '2〜3ターンの間あばれる状態になり、その間攻撃し続ける。攻撃終了後、自分がこんらん状態になる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 20;

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
        // 現在あばれる状態でなければ「あばれる状態」をセット
        if(!$atk->checkSc('ScThrash')){
            // あばれる状態をセット
            $atk->setSc('ScThrash', random_int(2, 3), get_class());
        }
        // ターンカウントを進める
        $atk->goScTurn('ScThrash');
        // あばれる状態が解除されており、こんらん状態でなければ、こんらん状態にする
        if(!$atk->checkSc('ScThrash') && !$atk->checkSc('ScConfusion')){
            $msg = $atk->setSc('ScConfusion', random_int(1, 4));
            $this->setMessage($msg);
        }
    }

}
