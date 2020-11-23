<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// わるあがき
class MoveStruggle extends Move
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
    protected $type = 'TypeNone';

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
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * 反動
    *
    * @param array $args
    * @return array
    */
    public function recoil(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;

        $damage = floor($atk->getStats('HP') / 4);
        $atk->calRemainingHp('sub', $damage);
        // メッセージとレスポンスを返却
        return [
            'message' => $atk->getPrefixName().'は反動を受けた',
            'response' => [
                'param' => $damage,
                'action' => 'hpbar',
                'target' => $atk->getPosition(),
            ]
        ];
    }

}
