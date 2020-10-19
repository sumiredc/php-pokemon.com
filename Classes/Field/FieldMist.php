<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/Field.php');

// しろいきり
class FieldMist extends Field
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'しろいきり';

    /**
    * フィールドセット時のメッセージ
    * @var string
    */
    protected $set_msg = '::prefixはしろいきりに包まれた';

    /**
    * 既にフィールドセットされている状態のメッセージ
    * @var string
    */
    protected $already_msg = 'しかし上手く決まらなかった';

    /**
    * フィールド解除時のメッセージ
    * @var string
    */
    protected $release_msg = '::prefixのしろいきりが晴れた';

    /**
    * デバフ無効化時のメッセージ
    * @var string
    */
    protected $failed_msg = '::pokemonはしろいきりに守られている';

}
