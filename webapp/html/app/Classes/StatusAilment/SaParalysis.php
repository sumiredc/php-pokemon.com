<?php

require_once app_path('Classes/StatusAilment.php');

/**
* まひ
*/
class SaParalysis extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'まひ';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'warning';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    public const SICKED_MSG = '::pokemonは、まひして技が出にくくなった';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    public const SICKED_ALREADY_MSG = '::pokemonは、既に麻痺している';

    /**
    * 行動失敗時のメッセージ
    * @var string
    */
    public const FAILED_MSG = '::pokemonは、体が痺れて動けない';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    public const RECOVERY_MSG = '::pokemonの体の痺れがとれた';

    /**
    * 行動前の状態異常発症
    * @param pokemon:object
    * @return array
    */
    public static function onsetBefore(object $pokemon): array
    {
        // 1/4の確率で行動不能
        if(random_int(0, 3)){
            // 行動可能
            return [
                'result' => true,
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
