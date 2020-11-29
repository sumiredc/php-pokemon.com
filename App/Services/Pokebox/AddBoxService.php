<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
* ボックスの追加
*/
class AddBoxService extends Service
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
        // ボックスの追加
        if(count(pokebox()->getPokebox()) < 10){
            $box = pokebox()->addBox();
            response()->setMessage('ボックス'.($box + 1).'を追加しました');
        }else{
            response()->setMessage('これ以上は追加できません');
        }
    }

}
