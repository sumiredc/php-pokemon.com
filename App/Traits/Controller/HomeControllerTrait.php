<?php

/**
* ホームコントローラー用トレイト
*/
trait HomeControllerTrait
{

    // /**
    // * 戦闘に参加するポケモンが存在しているかの確認
    // * @return boolean
    // */
    // protected function checkBattleStart(): bool
    // {
    //     $orders = array_filter(player()->getParty(), function($partner){
    //         return $partner->isFight();
    //     });
    //     if(empty($orders)){
    //         return false;
    //     }else{
    //         return true;
    //     }
    // }

    /**
    * ショップ情報の取得
    * @return array
    */
    public function getShop()
    {
        // carry初期値
        $initial = array_map(function(){
            return [];
        }, array_flip(config('item.categories')));
        // カテゴリ分け
        $items = array_reduce(config('shop'), function($carry, $class){
            $item = new $class;
            $carry[$item->getCategory()][] = [
                'order' => array_search($class, config('shop')), # ショップ内のアイテム番号
                'item' => $item,
                'owned' => player()->getItemCount($class), # 所有数
            ];
            return $carry;
        }, $initial);
        // 空カテゴリを除いて返却
        return array_filter($items, function($item){
            return !empty($item);
        });
    }

}
