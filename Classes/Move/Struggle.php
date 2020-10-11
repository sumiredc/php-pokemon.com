<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// わるあがき
class Struggle extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'わるあがき';

    /**
    * 説明文
    * @var string
    */
    protected $description = '使用するたびに反動ダメージを受ける。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeNull';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 50;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = null;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = null;

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
        $msg_id = $this->issueMsgId();
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 自分の最大HPの1/4ダメージを受ける
        $damage = floor($atk->getStats('HP') / 4);
        $atk->calRemainingHp('sub', $damage);
        $this->setMessage($atk->getPrefixName().'は反動を受けた', $msg_id);
        // HPバーのアニメーション用レスポンス
        $this->setResponse([
            'param' => $damage,
            'action' => 'hpbar',
            'target' => $atk->getPosition(),
        ], $msg_id);
    }

}
