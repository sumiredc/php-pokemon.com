<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// あなをほる
class MoveDig extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'あなをほる';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '1ターン目で地中に潜り、2ターン目に攻撃する。地中に潜っている間はほとんどの技を受けない。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeGround';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'physical';

    /**
    * 威力
    * @var integer
    */
    public const POWER = 80;

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
    * チャージ中に回避できない技
    * @var array
    */
    public const CANT_ESCAPE_MOVE = ['MoveEarthquake'];

    /**
    * チャージ
    *
    * @param object $atk
    * @return mixed (string:準備ターン, false:攻撃ターン)
    */
    public static function charge($atk)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
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
