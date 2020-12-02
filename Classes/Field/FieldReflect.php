<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Field.php');

/**
* リフレクター
*/
class FieldReflect extends Field
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'リフレクター';

    /**
    * フィールドセット時のメッセージ
    * @var string
    */
    public const SET_MSG = '::prefixはリフレクターで物理に強くなった';

    /**
    * 既にフィールドセットされている状態のメッセージ
    * @var string
    */
    public const ALREADY_MSG = 'しかし上手く決まらなかった';

    /**
    * フィールド解除時のメッセージ
    * @var string
    */
    public const RELEASE_MSG = '::prefixのリフレクターが無くなった';

}
