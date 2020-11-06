<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ちきゅうなげ
class MoveSeismicToss extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ちきゅうなげ';

    /**
    * 説明文
    * @var string
    */
    protected $description = '自分のレベル分の固定ダメージを与える';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeFighting';

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
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * ダメージ固定技フラグ
    * @var boolean
    */
    protected $fixed_damage_flg = true;

    /**
    * 固定ダメージ量の取得
    *
    * @param args:array
    * @return integer
    */
    public function getFixedDamage(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        * @param battle_state:object::BattleState バトル状態
        */
        list($atk, $def, $battle_state) = $args;
        // 攻撃ポケモンのレベル分ダメージを与える
        return $atk->getLevel();
    }

}
