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
    protected $set_msg = 'しろいきりに包まれた';

    /**
    * 既にフィールドセットされている状態のメッセージ
    * @var string
    */
    protected $already_msg = '既にしろいきりに包まれている';

    /**
    * フィールド解除時のメッセージ
    * @var string
    */
    protected $release_msg = 'しろいきりが晴れた';

    /**
    * デバフ無効化時のメッセージ
    * @var string
    */
    protected $failed_msg = '::pokemonは、しろいきりに守られている';

}
