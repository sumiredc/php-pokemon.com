<?php
require_once(app_path('Services').'Service.php');

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
