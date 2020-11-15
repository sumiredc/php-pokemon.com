<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
* フレンドリィショップ
*/
class ShopService extends Service
{

    /**
    * @var object::Player
    */
    protected $player;

    /**
    * @return void
    */
    public function __construct($player)
    {
        $this->player = $player;
    }

    /**
    * @return void
    */
    public function execute()
    {
        switch (request('do')) {
            // 購入
            case 'buy':
            $this->buy();
            break;
            // 売却
            case 'sell':
            $this->sell();
            break;
        }
    }

    /**
    * 購入
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
        if($this->player->getMoney() < $price){
            setMessage('おこづかいが足りません');
            return;
        }
        // 残金調整とアイテムの獲得処理
        $result = $this->player
        ->addItem($item, request('count'));
        if($result){
            $this->player
            ->subMoney($price);
            setMessage('毎度ありがとうございました');
        }else{
            setMessage('お客さん、そんなに持てませんよ');
        }
    }

    /**
    * 売却
    * @return void
    */
    private function sell(): void
    {
        //
    }

}
