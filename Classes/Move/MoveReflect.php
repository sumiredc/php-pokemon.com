<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// リフレクター
class MoveReflect extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'リフレクター';

    /**
    * 説明文
    * @var string
    */
    protected $description = '5ターンの間、相手の物理技のダメージが半分になる。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypePsychic';

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
    protected $priority = 0;

    /**
    * フィールド効果
    *
    * @return array
    */
    public function field()
    {
        return [
            'class' => 'FieldReflect',
            'turn' => 5,
        ];
    }

}