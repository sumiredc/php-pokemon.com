<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ふきとばし
class MoveWhirlwind extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ふきとばし';

    /**
    * 説明文
    * @var string
    */
    protected $description = '野生ポケモンとの戦闘を終了させる。トレーナー戦で使うと、相手ポケモンをランダムに交代させる。';

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
    protected $pp = 20;

    /**
    * 優先度
    * @var integer
    */
    protected $priority = -6;

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
        // バトル終了
        return [
            'message' => $def->getPrefixName().'は吹き飛ばされた',
            'end' => true
        ];
    }

}
