<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// オウムがえし
class MoveMirrorMove extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'オウムがえし';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '相手が最後に使った技を出す。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeFlying';

    /**
    * 分類
    * @var string(physical:物理|special:特殊|status:変化)
    */
    public const SPECIES = 'status';

    /**
    * 威力
    * @var integer
    */
    public const POWER = null;

    /**
    * 命中率
    * @var integer
    */
    public const ACCURACY = null;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 20;

    /**
    * 対象(使ったポケモンから見た立場)
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * オウム返し専用効果
    *
    * @param def:object::Pokemon 防御ポケモン
    * @param battle_state:object::BattleState バトル状態
    * @return mixed
    */
    public static function exMirrorMove($def, $battle_state)
    {
        $black_list = [
            // オウム返し・カウンター・わるあがき・ものまね・へんしん
            get_class(), 'MoveCounter', 'MoveStruggle', 'MoveMimic', 'MoveTransform'
        ];
        // 相手が最後に使用した技を取得
        $move_class = $battle_state->getLastMove($def->getPosition());
        // 技が取得できない、またはコピーできない技一覧と一致すれば失敗
        if(
            empty($move_class) ||
            in_array($move_class, $black_list, true)
        ){
            return false;
        }
        // 取得した技をインスタンス化
        $move = new $move_class;
        if($move->getTarget() === 'friend'){
            return false;
        }
        // 成功（技のインスタンスを返却）
        return $move;
    }

}
