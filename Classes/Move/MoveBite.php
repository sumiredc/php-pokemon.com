<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// かみつく
class Moveite extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'かみつく';

    /**
    * 説明文
    * @var string
    */
    protected $description = '30％の確率で敵をひるませる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeDark';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 60;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 25;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * 追加効果
    *
    * @param array $args
    * @return mixed
    */
    public function effects(...$args)
    {
        // 30%の確率
        if(30 < random_int(1, 100)){
            // random_intで31以上が生成されたら失敗
            return;
        }
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手をひるませる
        return [
            'message' => $def->setSc('ScFlinch')
        ];
    }

}
