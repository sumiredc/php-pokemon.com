<?php

require_once app_path('Classes/Move.php');

// ロケットずつき
class MoveSkullBash extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ロケットずつき';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '1ターン目は準備し、2ターン目に攻撃する。準備ターンに自分の防御が1段階上がる。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
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
        * @param atk:object::Pokemon 攻撃ポケモン
        */
        // チャージ前後の分岐
        if($atk->isChargeMove(get_class())){
            // チャージ完了
            $atk->initSc('ScCharge');
            return false;
        }else{
            // チャージ開始
            // 自身をチャージ状態にする
            return $atk->setSc('ScCharge', 1, get_class());
        }

    }

}
