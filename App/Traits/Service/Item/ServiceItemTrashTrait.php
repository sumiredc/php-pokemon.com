<?php
// アイテム破棄の処理
trait ServiceItemTrashTrait
{
    /**
    * 捨てる
    * @return void
    */
    protected function trash(): void
    {
        // 数のチェック
        if(empty(request('count'))){
            setMessage('個数を選択してください');
            return;
        }
        // 捨てる前にプレイヤーの道具一覧を取得
        $items = player()->getItems();
        // 道具を捨てる
        $result = player()->subItem(request('order'), request('count'));
        // 確認
        if($result){
            // インスタンス化
            $item = new $items[request('order')]['class'];
            setMessage($item->getName().'を'.request('count').'個捨てました');
        }else{
            setMessage('失敗しました');
        }
    }
}
