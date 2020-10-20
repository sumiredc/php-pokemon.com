<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// はかいこうせん
class MoveHyperBeam extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'はかいこうせん';

    /**
    * 説明文
    * @var string
    */
    protected $description = '使ったポケモンは次のターン、反動で動けない。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 150;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 90;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 5;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * 追加効果
    *
    * @param array $args
    * @return void
    */
    public function effects(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // はんどうをセット
        $atk->setSc('ScRecoil');
    }

}
