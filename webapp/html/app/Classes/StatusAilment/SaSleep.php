<?php

require_once app_path('Classes/StatusAilment.php');

/**
* ねむり
*/
class SaSleep extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ねむり';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'info';

    /**
    * 捕獲時の補正値
    * @var float
    */
    public const CAPTURE = 2.5;

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、眠ってしまった';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = '::pokemonは、既に眠っている';

    /**
    * 行動失敗時に表示されるメッセージ
    * @var string
    */
    public const FAILED_MSG = '::pokemonは、ぐうぐう眠っている';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = '::pokemonは、目を覚ました';

    /**
    * 行動前の状態異常発症
    * @param pokemon:object
    * @return array
    */
    public static function onsetBefore(object $pokemon): array
    {
        // ターンカウントを進める
        $pokemon->goSaTurn();
        // ターンカウントが残っていれば行動不能
        if($pokemon->getSa()){
            // 行動不能
            return [
                'result' => false,
                'message' => static::getFailedMessage($pokemon->getPrefixName())
            ];
        }else{
            // ねむり解除
            return [
                'result' => true,
                'release' => true,
                'message' => static::getRecoveryMessage($pokemon->getPrefixName())
            ];
        }
    }

}
