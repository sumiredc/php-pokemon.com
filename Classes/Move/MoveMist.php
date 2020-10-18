<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// しろいきり
class MoveMist extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'しろいきり';

    /**
    * 説明文
    * @var string
    */
    protected $description = '5ターンの間、場をしろいきり状態にして能力を下げられなくする。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeIce';

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
    protected $pp = 30;

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
            'class' => 'FieldMist',
            'turn' => 5,
        ];
    }

}
