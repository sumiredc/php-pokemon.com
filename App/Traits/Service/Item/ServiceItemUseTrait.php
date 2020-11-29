<?php
// アイテムを使用する処理
trait ServiceItemUseTrait
{

    /**
    * 使う（対象：ポケモン）
    * @param item:object::Item
    * @return boolean
    */
    protected function useItemToFriend(object $item): bool
    {
        // パーティー取得
        $party = player()->getParty();
        // パーティーに指定されたポケモンが存在しているかどうか確認
        if(!isset($party[request('pokemon')])){
            setMessage('使っても効果がないよ');
            return false;
        }
        // アイテム効果を使用
        $result = $item->effects($party[request('pokemon')]);
        // メッセージが返ってきていればセット
        if(isset($result['message'])){
            setMessage($result['message']);
        }
        return $result['result'];
    }

    /**
    * 使う（対象：プレイヤー）
    * @param item:object::Item
    * @return boolean
    */
    protected function useItemToPlayer(object $item): bool
    {
        //
        return true;
    }

    /**
    * 使う（対象：相手※ボールを除く）
    * @param item:object::Item
    * @return boolean
    */
    protected function useItemToEnemy(object $item): bool
    {
        //
        return true;
    }

}