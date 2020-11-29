<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
* ポケモンを預ける
*/
class DepositService extends Service
{

    /**
    * 預けるポケモン
    * @var object::Pokemon
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
            // 預け入れ処理
            $this->migratePartyToBox();
            // 接続成功
            response()->setMessage(
                $this->pokemon->getNickname().'をボックス'.pokebox()->getSelectedBoxNumber().'へ預けた'
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
        * ボックスの検証
        */
        // 空きチェック
        if(!pokebox()->isSelectedBoxSpace()){
            response()->setMessage('ボックス'.pokebox()->getSelectedBoxNumber().'には空きがありません');
            return false;
        }
        /**
        * ポケモンの検証
        */
        // 手持ちが1匹以下
        if(count(player()->getParty()) <= 1){
            response()->setMessage('手持ちのポケモンが、いなくなってしまいます');
            return false;
        }
        // 手持ちポケモンの存在チェック
        $this->pokemon = player()->getPartner(request('pokemon_id'), 'id');
        if(empty($this->pokemon)){
            response()->setMessage('選択されたポケモンは預けることができません');
            return false;
        }
        // 検証成功
        return true;
    }

    /**
    * ポケモンをボックスへ預ける
    * @return void
    */
    private function migratePartyToBox(): void
    {
        // パーティー内のポケモン情報を削除
        player()->releasePartner(request('pokemon_id'));
        // ボックスへ追加
        pokebox()->addPokemon($this->pokemon);
    }

}
