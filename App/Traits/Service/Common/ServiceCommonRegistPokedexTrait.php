<?php
/**
* ポケモン図鑑への登録用トレイト
*/
trait ServiceCommonRegistPokedexTrait
{
    /**
    * ポケモン図鑑への登録からモーダルの生成処理
    * @param pokemon:object::Pokemon
    * @return void
    */
    protected function setModalRegistPokedex(object $pokemon): void
    {
        if(player()->pokedex()->isRegisted($pokemon::NUMBER) >= 2){
            // 登録の必要無し
            return;
        }
        // 登録処理
        player()->pokedex()
        ->regist($pokemon);
        // モーダルID生成
        $regist_id = response()->issueMsgId();
        // メッセージの生成
        response()->setMessage($pokemon::NAME.'のデータが、新しくポケモン図鑑に登録されます', $regist_id);
        // モーダルの生成
        response()->setModal([
            'id' => $regist_id,
            'modal' => 'regist-pokedex',
            'pokemon' => get_class($pokemon)
        ]);
        // レスポンスの生成
        response()->setResponse([
            'toggle' => 'modal',
            'target' => '#'.$regist_id.'-modal'
        ], $regist_id);
    }

}
