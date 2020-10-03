<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StatusAilment.php');

// やけど
class SaBurn extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'やけど';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、やけどを負った';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    protected $sicked_already_msg = '::pokemonは、既にやけどしている';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    protected $turn_msg = '::pokemonは、やけどのダメージを受けている';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    protected $recovery_msg = '::pokemonは、やけどが治った';

}
