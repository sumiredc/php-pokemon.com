<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

//かぜおこし
class MoveGust extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'かぜおこし';

    /**
    * 説明文
    * @var string
    */
    protected $description = 'そらをとぶ状態のポケモンにも命中し、その場合は威力が2倍になる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeFlying';

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
    protected $pp = 35;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * 威力補正値の取得
    *
    * @param mixed
    * @return integer
    */
    public function powerCorrection(...$args)
    {
        /**
        * @param Pokemon:object $atk 攻撃ポケモン
        * @param Pokemon:object $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // もし相手がそらをとぶチャージ中なら威力2倍
        if($def->getChargeMove() === 'MoveFly'){
            return 2;
        }
        // 通常補正値
        return 1;
    }

}
