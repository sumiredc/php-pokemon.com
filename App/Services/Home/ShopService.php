<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
* フレンドリィショップ
*/
class ShopService extends Service
{

    // /**
    // * @var object::Player
    // */
    // protected $player;

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
            // 買う
            case 'buy':
            $this->buy();
            break;
            // 売る
            case 'sell':
            $this->sell();
            break;
        }
    }

    /**
    * バリデーション
    * @return boolean
    */
    private function validation(): bool
    {
        // 商品選択
        if(!is_numeric(request('order'))){
            setMessage('どうぐを選択してください');
            $result = false;
        }
        // 数
        if(!is_numeric(request('count'))){
            setMessage('個数を選択してください');
            $result = false;
        }
        return $result ?? true;
    }

    /**
    * 買う
    * @return void
    */
    private function buy(): void
    {
        $class = config('shop.'.request('order'));
        if(empty($class)){
            setMessage('指定されたアイテムは販売しておりません');
            return;
        }
        // アイテムをインスタンス化
        $item = new $class;
        // 購入金額の算出
        $price = $item->getBidPrice() * request('count');
        if(player()->getMoney() < $price){
            setMessage('おこづかいが足りません');
            return;
        }
        // 残金調整とアイテムの獲得処理
        $result = player()->addItem($item, request('count'));
        if($result){
            player()->subMoney($price);
            setMessage('毎度ありがとうございました');
        }else{
            setMessage('お客さん、そんなに持てませんよ');
        }
    }

    /**
    * 売る
    * @return void
    */
    private function sell(): void
    {
        // 消費前にプレイヤーのアイテム一覧を取得
        $items = player()->getItems();
        // アイテムの消費
        $result = player()->subItem(request('order'), request('count'));
        // 消費チェック
        if($result){
            // インスタンス化
            $item = new $items[request('order')]['class'];
            // おこづかいに加算
            player()->addMoney($item->getSellPrice() * request('count'));
            setMessage('毎度ありがとうございました');
        }else{
            setMessage('お客さん、そんなに持っていませんよ');
        }
    }

}
