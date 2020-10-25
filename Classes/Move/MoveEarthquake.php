<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// じしん
class MoveEarthquake extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'じしん';

    /**
    * 説明文
    * @var string
    */
    protected $description = 'あなをほる状態のポケモンにも命中し、2倍のダメージを与えられる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeGround';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 100;

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
    protected $targeet = 'enemy';

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
        // もし相手があなをほるチャージ中なら威力2倍
        if($def->getChargeMove() === 'MoveDig'){
            return 2;
        }
        // 通常補正値
        return 1;
    }

}
