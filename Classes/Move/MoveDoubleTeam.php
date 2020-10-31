<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// かげぶんしん
class MoveDoubleTeam extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'かげぶんしん';

    /**
    * 説明文
    * @var string
    */
    protected $description = '自分の回避率を1段階上げる。';

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
    protected $accuracy = null;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 15;

    /**
    * 対象
    * @var string
    */
    protected $target = 'friend';

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
        // 自分の回避率ランクを1段階上げる
        return [
            'message' => $atk->addRank('Evasion', 1)
        ];
    }

}
