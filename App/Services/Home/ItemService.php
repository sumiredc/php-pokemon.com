<?php
require_once(app_path('Services').'Service.php');
// トレイト
require_once(app_path('Traits.Service.Item').'ServiceItemUseTrait.php');
require_once(app_path('Traits.Service.Item').'ServiceItemTrashTrait.php');

/**
* アイテムの操作
*/
class ItemService extends Service
{

    use ServiceItemUseTrait;
    use ServiceItemTrashTrait;

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
        // バリデーション
        if(!$this->validation()){
            return;
        }
        // 分岐
        switch (request('do')) {
            // 使う
            case 'use':
            $this->use();
            break;
            // 捨てる
            case 'trash':
            $this->trash();
            break;
        }
    }

    /**
    * バリデーション
    * @return boolean
    */
    private function validation(): bool
    {
        // アイテムの存在チェック
        if(!player()->isItem(request('order'))){
            response()->setMessage('選択されたどうぐは存在しません');
            return false;
        }else{
            return true;
        }
    }

    /**
    * 使う
    * @return void
    */
    private function use(): void
    {
        // 道具を取得
        $item = player()->getItemClass(request('order'));
        // アイテムの対象による分岐
        switch ($item::TARGET) {
            // 味方ポケモン
            case 'friend':
            $result = $this->useItemToFriend($item);
            break;
            // プレイヤー
            case 'player':
            $result = $this->useItemToPlayer($item);
            break;
        }
        // アイテムを1つ消費
        if($result){
            player()->subItem(request('order'));
        }
    }

}
