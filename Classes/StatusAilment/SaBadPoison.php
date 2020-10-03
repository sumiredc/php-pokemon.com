<?php
$root_path = __DIR__.'/../..';
require_once($root_path.'/Classes/StatusAilment.php');

// もうどく
class SaBadPoison extends StatusAilment
{

    /**
    * 正式名称
    * @var string
    */
    protected $name = 'もうどく';

    /**
    * 状態異常にかかった際のメッセージ
    * @var string
    */
    protected $sicked_msg = '::pokemonは、猛毒を浴びた';

    /**
    * すでにこの状態異常にかかっている際のメッセージ
    * @var string
    */
    protected $sicked_already_msg = '::pokemonは、既に毒に侵されている';

    /**
    * ターンチェック時に表示されるメッセージ
    * @var string
    */
    protected $turn_msg = '::pokemonは、毒のダメージを受けている';

    /**
    * 回復時に表示されるメッセージ
    * @var string
    */
    protected $recovery_msg = '::pokemonの毒は綺麗サッパリ無くなった';

}
