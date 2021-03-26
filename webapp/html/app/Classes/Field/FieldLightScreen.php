<?php
require_once app_path('Classes/Field.php');

/**
* ひかりのかべ
*/
abstract class FieldLightScreen extends Field
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'ひかりのかべ';

    /**
    * フィールドセット時のメッセージ
    * @var string
    */
    public const SET_MSG = '::prefixはひかりのかべで特殊に強くなった';

    /**
    * 既にフィールドセットされている状態のメッセージ
    * @var string
    */
    public const ALREADY_MSG = 'しかし上手く決まらなかった';

    /**
    * フィールド解除時のメッセージ
    * @var string
    */
    public const RELEASE_MSG = '::prefixのひかりのかべが無くなった';

}
