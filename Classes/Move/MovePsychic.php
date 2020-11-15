<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// サイコキネシス
class MovePsychic extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'サイコキネシス';

    /**
    * 説明文
    * @var string
    */
    protected $description = '追加効果として10%の確率で相手のとくぼうを1段階下げる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypePsychic';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'special';

    /**
    * 威力
    * @var integer
    */
    protected $power = 90;

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
    * 能力下降効果
    *
    * @param array $args
    * @return array
    */
    public function debuff(...$args)
    {
        // 10%の確率
        if(10 < random_int(1, 100)){
            // random_intで11以上が生成されたら失敗
            return;
        }
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手のとくぼうランクを1段階下げる
        return [
            'message' => $def->subRank('SpDef', 1)
        ];
    }

}
