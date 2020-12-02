<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
* パーティーの並び替え
*/
class SortPartyService extends Service
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
        // 並び替え処理
        $this->sortOrders();
    }

    /**
    * パーティーの並び替え
    * @return void
    */
    private function sortOrders(): void
    {
        // 送られてきた並び順を一意にする
        $orders = array_unique(
            json_decode(request('orders'))
        );
        // 並び替えの実行
        if(player()->sortParty($orders)){
            response()->setMessage('ポケモンの並び替えをしました');
        }else{
            response()->setMessage('並び替えに失敗しました');
        }
    }

}
