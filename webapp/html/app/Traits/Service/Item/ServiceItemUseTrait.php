<?php
// アイテムを使用する処理
trait ServiceItemUseTrait
{

    /**
    * 使う（対象：ポケモン）
    * @param item:string
    * @return boolean
    */
    protected function useItemToFriend(string $item): bool
    {
        // パーティー取得
        $party = player()->getParty();
        // パーティーに指定されたポケモンが存在しているかどうか確認
        if(!isset($party[request('pokemon')])){
            response()->setMessage('使っても効果がないよ');
            if(getPageName() === 'home'){
                response()->setToastr('error', '使っても効果がないよ');
            }
            return false;
        }
        // アイテム効果を使用
        $result = $item::effects($party[request('pokemon')]);
        // メッセージが返ってきていればセット
        if(isset($result['message'])){
            response()->setMessage($result['message']);
            if(getPageName() === 'home'){
                response()->setToastr(
                    ($result['result'] ?? false) ? 'success' : 'error',
                    $result['message']
                );
            }
        }
        // アクションの確認(進化判定等)
        if(
            isset($result['action']) &&
            $result['result'] ?? false
        ){
            // レスポンスにアクションをセット
            response()->setResponse($result['action'], 'action');
        }
        // 描画処理(バトルポケモンへのアイテム使用であれば)
        if(
            getPageName() === 'battle' &&
            (int)request('pokemon') === battle_state()->getOrder()
        ){
            // HPバーの変動処理
            if(isset($result['hpbar'])){
                response()->setResponse([
                    'param' => $result['hpbar'],
                    'action' => 'hpbar',
                    'target' => 'friend',
                ], $this->use_msg_id);
            }
        }
        return $result['result'];
    }

    /**
    * 使う（対象：現在バトル中のポケモン）
    * @param item:string
    * @return boolean
    */
    protected function useItemToFriendBattle(string $item): bool
    {
        // アイテム効果を使用
        $result = $item::effects(friend());
        // メッセージが返ってきていればセット
        if(isset($result['message'])){
            response()->setMessage($result['message']);
        }
        // HPバーの変動処理(もしあれば)
        if(isset($result['hpbar'])){
            response()->setResponse([
                'param' => $result['hpbar'],
                'action' => 'hpbar',
                'target' => 'friend',
            ], $this->use_msg_id);
        }
        return $result['result'];
    }

    /**
    * 使う（対象：プレイヤー）
    * @param item:string
    * @return boolean
    */
    protected function useItemToPlayer(string $item): bool
    {
        //
        return true;
    }

    /**
    * 使う（対象：相手※ボールを除く）
    * @param item:string
    * @return boolean
    */
    protected function useItemToEnemy(string $item): bool
    {
        //
        return true;
    }

}
