<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// げきりん
class MoveOutrage extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'げきりん';

    /**
    * 説明文
    * @var string
    */
    protected $description = '使ったポケモンは次のターン、反動で動けない。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeDragon';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 120;

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
    * 追加効果
    *
    * @param array $args
    * @return mixed
    */
    public function effects(...$args)
    {
        /**
        * @param Pokemon $atk 攻撃ポケモン
        * @param Pokemon $def 防御ポケモン
        */
        list($atk, $def) = $args;
        // 現在あばれる状態でなければ「あばれる状態」をセット
        if(!$atk->checkSc('ScThrash')){
            // あばれる状態をセット
            $atk->setSc('ScThrash', random_int(2, 3), get_class());
        }
        // ターンカウントを進める
        $atk->goScTurn('ScThrash');
        // あばれる状態が解除されており、こんらん状態でなければ、こんらん状態にする
        if(!$atk->checkSc('ScThrash') && !$atk->checkSc('ScConfusion')){
            return [
                'message' => $atk->setSc('ScConfusion', random_int(1, 4))
            ];
        }
    }

}
