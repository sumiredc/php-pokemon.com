<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ソーラービーム
class MoveSolarBeam extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ソーラービーム';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '1ターン目に溜め、2ターン目で攻撃する。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGrass';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'special';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 120;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 100;

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
    * チャージ技
    * @var boolean
    */
    public const CHARGE_FLG = true;

    /**
    * チャージ
    *
    * @param object $atk
    * @return mixed (array:準備ターン, false:攻撃ターン)
    */
    public static function charge($atk)
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
            return $atk->setSc('ScCharge', 1, get_class());
        }

    }

}
