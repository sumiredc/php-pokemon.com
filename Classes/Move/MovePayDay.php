<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// ネコにこばん
class MovePayDay extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ネコにこばん';

    /**
    * 説明文
    * @var string
    */
    protected $description = '戦いが終わったらお金を拾える。';

    /**
    * タイプ
    * @var string
    */
    protected $type = 'TypeNormal';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    protected $species = 'physical';

    /**
    * 威力
    * @var integer
    */
    protected $power = 40;

    /**
    * 命中率
    * @var integer
    */
    protected $accuracy = 100;

    /**
    * 使用回数
    * @var integer
    */
    protected $pp = 20;

    /**
    * 対象
    * @var string
    */
    protected $target = 'enemy';

    /**
    * ネコにこばんの特別処理
    * @param atk:object::Pokemon
    * @param battle_state:object::BattleState
    * @return void
    */
    public function exPayDay($atk, $battle_state)
    {
        // レベル x 5円をセット
        $battle_state->setMoney(
            $atk->getLevel() * 5
        );
    }

}
