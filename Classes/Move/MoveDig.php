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
    protected $name = 'あなをほる';

    /**
    * 説明文
    * @var string
    */
    protected $description = '1ターン目で地中に潜り、2ターン目に攻撃する。地中に潜っている間はほとんどの技を受けない。';

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
    protected $power = 80;

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
    protected $target = 'enemy';

    /**
    * チャージ技
    * @var boolean
    */
    protected $charge_flg = true;

    /**
    * チャージ中に回避できない技
    * @var array
    */
    protected $cant_escape_move = ['MoveEarthquake'];

    /**
    * チャージ
    *
    * @param object $atk
    * @return mixed (string:準備ターン, false:攻撃ターン)
    */
    public function charge($atk)
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
