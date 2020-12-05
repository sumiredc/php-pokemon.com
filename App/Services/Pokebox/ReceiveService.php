<?php
require_once(app_path('Services').'Service.php');

/**
* ポケモンを引き取る
*/
class ReceiveService extends Service
{

    /**
    * 引き取るポケモン
    * @var array
    */
    private $pokemon;

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
        if($this->validation()){
            // 引き取り処理
            $this->migrateBoxToParty();
            // 接続成功
            response()->setMessage(
                $this->pokemon
                ->getNickname().'を連れて行くことにした'
            );
        }
    }

    /**
    * 検証
    * @return boolean
    */
    private function validation(): bool
    {
        /**
        * パーティーの検証
        */
        if(count(player()->getParty()) >= 6){
            response()->setMessage('これ以上は連れていけません');
            return false;
        }
        /**
        * ボックス内のポケモンの検証
        */
        $pokemon = array_filter(pokebox()->accessSelectedBox(false), function($pokemon){
            return $pokemon['id'] === request('pokemon_id');
        });
        if(empty($pokemon)){
            response()->setMessage('指定されたポケモンは存在しません');
            return false;
        }
        // 検証成功
        $this->pokemon = unserializeObject(array_shift($pokemon)['object']);
        return true;
    }

    /**
    * ボックスからパーティーへの移動
    * @return void
    */
    private function migrateBoxToParty(): void
    {
        // ボックスからポケモンを削除する
        pokebox()->releasePokemon(request('pokemon_id'));
        // 取り出したポケモンをパーティーへセットする
        player()->setParty($this->pokemon);
    }

}
