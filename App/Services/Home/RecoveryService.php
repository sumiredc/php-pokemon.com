<?php
require_once(app_path('Services').'Service.php');

/**
* ポケモンセンター
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
        response()->setMessage([
            'お預かりしたポケモンたちは、皆元気になりましたよ',
            'またのご利用お待ちしております'
        ]);
        response()->setEmptyMessage();
        response()->setToastr('success', 'ポケモンの状態が万全になった！');
    }

}
