<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Move.php');

// かなしばり
class MoveDisable extends Move
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'かなしばり';

    /**
    * 説明文
    * @var string
    */
    public const DESCRIPTION = '直前に相手が使ったわざを4ターン使えなくする。';

    /**
    * タイプ
    * @var string
    */
    public const TYPE = 'TypeNormal';

    /**
    * 分類
    * @var string::physical:物理|special:特殊|status:変化
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
    public const ACCURACY = 100;

    /**
    * 使用回数
    * @var integer
    */
    public const PP = 20;

    /**
    * 対象
    * @var string
    */
    public const TARGET = 'enemy';

    /**
    * 追加効果
    * @param args:array
    * @return void
    */
    public static function effects(...$args)
    {
        /**
        * @param atk:object::Pokemon 攻撃ポケモン
        * @param def:object::Pokemon 防御ポケモン
        */
        list($atk, $def) = $args;
        // 相手をかなしばり状態にする
        $last = battle_state()->getSelectedMove($def->getPosition());
        $move = array_filter($def->getMove(), function($move) use($last){
            // 間近に選択された技が存在しているか確認
            return $move['class'] === $last;
        });
        // 判定(既にかかっている場合は状態変化のセット時に判定)
        if(
            empty($move) ||
            empty($last)
        ){
            // 縛れる技が無いので失敗
            $message = ScDisable::getSickedAlreadyMessage($def->getPrefixName());
        }else{
            // かなしばり発動（もし既にかかっていれば失敗）
            $message = $def->setSc('ScDisable', 4, $last);
        }
        // メッセージの返却
        return [
            'message' => $message
        ];
    }

}
