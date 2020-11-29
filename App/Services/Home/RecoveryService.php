<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * 全回復
 */
class RecoveryService extends Service
{

    /**
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 全回復
        foreach(player()->getParty() as $partner){
            $partner->recovery();
        }
        setMessage([
            ['お預かりしたポケモンたちは、皆元気になりましたよ'],
            ['またのご利用お待ちしております']
        ]);
    }

}
