<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// いやなおと
class MoveScreech extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'いやなおと';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手のぼうぎょを2段階下げる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeNormal';

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
    protected $accuracy = 85;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 40;

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
        // 相手の攻撃ランクを1段階下げる
        return [
            'message' => $def->subRank('Defense', 2)
        ];
    }

}
