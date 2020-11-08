<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// でんじは
class MoveThunderWave extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'でんじは';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手をまひ状態にする。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeElectric';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'status';

    /**
    * 威力
    * @var integer
    */
    protected $power = null;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 90;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 30;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * 追加効果
    *
    * @param array $args
    * @return array
    */
    public function effects(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手をまひ状態にする
        return $def->setSa('SaParalysis');
    }

}
