<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Field.php');

// ひかりのかべ
class FieldLightScreen extends Field
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'ひかりのかべ';

    /**
    * フィールドセット時のメッセージ
    * @var string
    */
    protected $set_msg = '::prefixはひかりのかべで特殊に強くなった';

    /**
    * 既にフィールドセットされている状態のメッセージ
    * @var string
    */
    protected $already_msg = 'しかし上手く決まらなかった';

    /**
    * フィールド解除時のメッセージ
    * @var string
    */
    protected $release_msg = '::prefixのひかりのかべが無くなった';

}
