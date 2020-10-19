<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Field.php');

// リフレクター
class FieldReflect extends Field
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'リフレクター';

    /**
    * フィールドセット時のメッセージ
    * @var string
    */
    protected $set_msg = '::prefixはリフレクターで物理に強くなった';

    /**
    * 既にフィールドセットされている状態のメッセージ
    * @var string
    */
    protected $already_msg = 'しかし上手く決まらなかった';

    /**
    * フィールド解除時のメッセージ
    * @var string
    */
    protected $release_msg = '::prefixのリフレクターが無くなった';

}
