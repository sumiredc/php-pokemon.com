<?php

/**
* ホームコントローラー用トレイト
*/
trait HomeControllerTrait
{

    /**
    * 戦闘に参加するポケモン番号を取得
    *
    * @return integer
    */
    protected function getFightPokemonOrder()
    {
        $orders = array_filter($this->party, function($partner){
            return $partner->getRemainingHp() > 0;
        });
        if(empty($orders)){
            return null;
        }else{
            return array_key_first($orders);
        }
    }

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
                'owned' => $this->player->getItemCount($class), # 所有数
            ];
            return $carry;
        }, $initial);
        // 空カテゴリを除いて返却
        return array_filter($items, function($item){
            return !empty($item);
        });
    }

}
