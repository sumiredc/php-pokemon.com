<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// そらをとぶ
class MoveFly extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'そらをとぶ';

    /**
    * 説明文
    * @var string
    */
    public const DESCTIPTION = '1ターン目で空に舞い上がり、2ターン目に攻撃する。空を飛んでいる間はほとんどの技を受けない。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeFlying';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 90;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = 95;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 15;

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
    * チャージ中に回避できない技
    * @var array
    */
    public const CANT_ESCAPE_MOVE = ['MoveThunder', 'MoveGust'];

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
        // チャージ前後の分岐
        if($atk->checkChargeMove(get_class())){
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
