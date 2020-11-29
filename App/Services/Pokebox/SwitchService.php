<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
* ボックスの切り替え
*/
class SwitchService extends Service
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
        // ボックスの切り替え
        if(pokebox()->selectBox(request('box'))){
            response()->setMessage(
                'ボックス'.pokebox()->getSelectedBoxNumber().'を起動しました'
            );
        }else{
            response()->setMessage('ボックスの起動に失敗しました');
        }
    }

}
