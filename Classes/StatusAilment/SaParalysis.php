<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StatusAilment.php');

// まひ
class SaParalysis extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'まひ';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、まひして技が出にくくなった';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    protected $sicked_already_msg = '::pokemonは、既に麻痺している';

    /**
    * 行動失敗時のメッセージ
    * @var string
    */
    protected $false_msg = '::pokemonは、体が痺れて動けない';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    protected $recovery_msg = '::pokemonの体の痺れがとれた';

}
