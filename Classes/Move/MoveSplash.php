<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// はねる
class MoveSplash extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'はねる';

    /**
    * 説明文
    * @var string
    */
    protected $description = '効果なし。';

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
    protected $pp = 40;

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
        response()->setMessage('しかし、何も起こらない！');
    }

}
