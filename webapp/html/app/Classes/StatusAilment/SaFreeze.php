<?php

require_once app_path('Classes/StatusAilment.php');

/**
* こおり
*/
class SaFreeze extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'こおり';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'primary';

    /**
    * 捕獲時の補正値
    * @var float
    */
    public const CAPTURE = 2.5;

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、氷漬けになった';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = '::pokemonは、既に凍っている';

    /**
    * 行動失敗時に表示されるメッセージ
    * @var string
    */
    public const FAILED_MSG = '::pokemonは、凍ってしまって動けない';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = '::pokemonの氷が溶けた';

    /**
    * 行動前の状態異常発症
    * @param pokemon:object
    * @return array
    */
    public static function onsetBefore(object $pokemon): array
    {
        // 1/5の確率でこおり解除
        if(!random_int(0, 4)){
            // こおり解除
            $pokemon->initSa();
            return [
                'result' => true,
                'release' => true,
                'message' => static::getRecoveryMessage($pokemon->getPrefixName()),
            ];
        }else{
            // 行動不能
            return [
                'result' => false,
                'message' => static::getFailedMessage($pokemon->getPrefixName())
            ];
        }
    }

}
