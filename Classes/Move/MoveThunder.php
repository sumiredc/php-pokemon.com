<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// かみなり
class MoveThunder extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'かみなり';

    /**
    * 説明文
    * @var string
    */
    protected $description = '30％の確立で相手をまひ状態にする。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeElectric';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 110;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 70;

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
        // 30%の確率
        if($def->getSa() || 30 < random_int(1, 100)){
            return;
        }
        // 相手をまひ状態にする
        $msg = $def->setSa('SaParalysis');
        // メッセージをセット
        $this->setMessage($msg);
    }

}
