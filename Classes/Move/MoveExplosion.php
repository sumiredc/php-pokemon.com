<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// だいばくはつ
class MoveExplosion extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'だいばくはつ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '使ったポケモンはひんしになる。';

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
    protected $power = 250;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 5;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * 技の使用コスト(技の成功・失敗に問わず発生)
    * @param arg:array
    * @return void
    */
    public function cost(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 瀕死処理の前に、攻撃ポケモンの残りHPをダメージとしてセット
        $msg_id = response()->issueMsgId();
        response()->setResponse([
            'param' => $atk->getRemainingHp(),
            'action' => 'hpbar',
            'target' => $atk->getPosition(),
        ], $msg_id);
        response()->setAutoMessage($msg_id);
        // 攻撃ポケモンに対して即死処理
        $atk->calRemainingHp('death');
    }

}
