<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ソーラービーム
class SolarBeam extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ソーラービーム';

    /**
    * 説明文
    * @var string
    */
    protected $description = '1ターン目に溜め、2ターン目で攻撃する。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Grass';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 120;

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
    * 優先度
    * @var integer
    */
    protected $priority = 0;

    /**
    * チャージ技
    * @var boolean
    */
    protected $charge_flg = true;

    /**
    * チャージ
    *
    * @param object $atk
    * @return boolean (true:準備ターン, false:攻撃ターン)
    */
    public function charge($atk)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        */
        // 状態変化の取得
        $sc = $atk->getSc();
        // チャージ前後の分岐
        if(isset($sc['ScCharge'])){
            // チャージ完了
            $atk->releaseSc('ScCharge');
            return false;
        }else{
            // チャージ開始
            // 自身をチャージ状態にする
            $msg = $atk->setSc('ScCharge', 1, get_class());
            $atk->setMessage($msg);
            return true;
        }

    }

}
