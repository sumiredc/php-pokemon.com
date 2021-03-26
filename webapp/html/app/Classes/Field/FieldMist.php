<?php
require_once app_path('Classes/Field.php');

/**
* しろいきり
*/
abstract class FieldMist extends Field
{

    /**
    * 正式名称
    * @var string
    */
    public const NAME = 'しろいきり';

    /**
    * フィールドセット時のメッセージ
    * @var string
    */
    public const SET_MSG = '::prefixはしろいきりに包まれた';

    /**
    * 既にフィールドセットされている状態のメッセージ
    * @var string
    */
    public const ALREADY_MSG = 'しかし上手く決まらなかった';

    /**
    * フィールド解除時のメッセージ
    * @var string
    */
    public const RELEASE_MSG = '::prefixのしろいきりが晴れた';

    /**
    * デバフ無効化時のメッセージ
    * @var string
    */
    public const FAILED_MSG = '::pokemonはしろいきりに守られている';

}
