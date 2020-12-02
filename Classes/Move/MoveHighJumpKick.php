<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// とびひざげり
class MoveHighJumpKick extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'とびひざげり';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '攻撃がはずれると自分最大HPの半分のダメージを受ける。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeFighting';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 130;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 90;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 10;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 技の失敗
    *
    * @param object Pokemon $atk
    * @return array
    */
    public static function failed($atk)
    {
        // 最大HPの1/2ダメージを受ける
        $damage = $atk->getStats('HP') / 2;
        $atk->calRemainingHp('sub', $damage);
        // レスポンスとメッセージを返却
        return [
            'message' => '勢い余って'.$atk->getPrefixName().'は地面にぶつかった',
            'response' => [
                'param' => $damage,
                'action' => 'hpbar',
                'target' => $atk->getPosition(),
            ]
        ];
    }

}
