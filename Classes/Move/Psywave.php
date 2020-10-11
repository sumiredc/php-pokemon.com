<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// サイコウェーブ
class Psywave extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'サイコウェーブ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手にランダムに決まった値を固定ダメージとして与える。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'Psychic';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

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
    protected $pp = 15;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = 0;

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
        // 攻撃ポケモンのレベル*(0.5〜1.5)倍のダメージを与える
        $damage = (int)($atk->getLevel() * (random_int(5, 15) / 10));
        // 最小ダメージの処理
        if(empty($damage)){
            $damage = 1;
        }
        return $damage;
    }

}
