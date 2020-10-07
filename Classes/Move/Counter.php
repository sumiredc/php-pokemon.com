<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// カウンター
class Counter extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'カウンター';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手から受けた物理攻撃のダメージを2倍にして与える。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Fighting';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = null;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 20;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = -5;

    /**
    * 固定ダメージフラグ
    * @var boolean
    */
    protected $fixed_damage_flg = true;

    /**
    * 固定ダメージ量の取得
    *
    * @param Pokemon $atk 攻撃ポケモン
    * @param Pokemon $def 防御ポケモン
    * @return integer
    */
    public function getFixedDamage($atk, $def)
    {
        // 攻撃ポケモンのレベル分ダメージを与える
        return $atk->getTurnDamage('physical') * 2;
    }

}
