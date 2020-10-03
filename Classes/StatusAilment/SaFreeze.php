<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StatusAilment.php');

// こおり
class SaFreeze extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'こおり';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、氷漬けになった';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    protected $sicked_already_msg = '::pokemonは、既に凍っている';

    /**
    * 行動失敗時に表示されるメッセージ
    * @var string
    */
    protected $false_msg = '::pokemonは、凍ってしまって動けない';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    protected $recovery_msg = '::pokemonの氷が溶けた';

}
