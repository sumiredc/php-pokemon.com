<?php

require_once(root_path('Classes').'StatusAilment.php');

/**
* ひんし
*/
class SaFainting extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ひんし';

    /**
    * 色
    * @var string
    */
    public const COLOR = 'secondary';

    /**
    * 捕獲時の補正値
    * @var float
    */
    public const CAPTURE = 0;

    /**
    * 行動前の状態異常発症
    * @param pokemon:object
    * @return array
    */
    public static function onsetBefore(object $pokemon): array
    {
        return [
            'result' => false
        ];
    }

}
