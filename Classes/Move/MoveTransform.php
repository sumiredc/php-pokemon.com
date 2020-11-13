<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// へんしん
class MoveTransform extends Move
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'へんしん';

    /**
    * 説明文
    * @var string
    */
    protected $description = '相手のポケモンに変身する。';

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
    * @var integer|null
    */
    protected $power = null;

    /**
    * 命中率
    * @var integer|null
    */
    protected $accuracy = null;

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
    * へんしんの専用効果
    * @param atk:object::Pokemon
    * @param def:object::Pokemon
    * @param battle_state:object::BattleState バトル状態
    * @return void
    */
    public function exTransform(object $atk, object $def, object $battle_state)
    {
        if(!$atk->checkSc('ScTransform')){
            // 現在へんしん状態でなければ実行
            $atk->setSc('ScTransform', 0, get_class($def)); # 先に状態変化（へんしん）をセット
            $battle_state->setTransform($atk, $def);
            return true;
        }else{
            // 現在へんしん状態であれば失敗
            return false;
        }
    }

}
