<?php
/**==================================================================
* どうぐ
==================================================================**/
trait ClassPlayerItemTrait
{

    /**
    * どうぐの取得
    * @return array
    */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
    * 所有数の取得
    * @param item:string
    * @return integer
    */
    public function getItemCount(string $item): int
    {
        // 初期値
        $count = 0;
        // アイテム検索
        $key = array_search(
            $item,
            array_column($this->items, 'class')
        );
        // もし所有していれば所有数を取得
        if(is_int($key)){
            $count = $this->items[$key]['count'];
        }
        return $count;
    }

    /**
    * かばんの生成
    * @return array
    */
    public function getBag(): array
    {
        // carry初期値
        $initial = array_map(function(){
            return [];
        }, array_flip(config('item.categories')));
        // カテゴリ分けした配列を返却
        return array_reduce($this->items, function($carry, $row){
            // アイテム番号を取得
            $order = array_search(
                $row['class'],
                array_column($this->items, 'class')
            );
            // カテゴリ分けして返却
            $carry[$row['class']::CATEGORY][] = [
                'class' => $row['class'],
                'count' => $row['count'],
                'order' => $order,
            ];
            return $carry;
        }, $initial);
    }

    /**
    * アイテムの追加
    * @param item:string
    * @param count:integer
    * @return boolean
    */
    public function addItem(string $item, $count=1): bool
    {
        if(is_null($item::MAX)){
            // 個数計算しないアイテムの場合はnullをセット
            $count = null;
        }else{
            // 数チェック
            if($count < 1){
                $count = 1; # 最小値
            }
            if($item::MAX < $count){
                $count = $item::MAX; # 最大値
            }
        }
        // 現在所有しているかどうかの確認
        $key = array_search(
            $item,
            array_column($this->items, 'class')
        );
        if($key === false){
            // 所有していない
            $this->items[] = [
                'class' => $item,
                'count' => $count
            ];
            return true;
        }else{
            // 個数計算するアイテム且つ最大量を超過しなければ個数を加算
            if(
                !is_null($count) &&
                ($this->items[$key]['count'] + $count) <= $item::MAX
            ){
                $this->items[$key]['count'] += $count;
            }else{
                return false;
            }
            return true;
        }
    }

    /**
    * アイテムの消費
    * @param order:integer
    * @param count:integer
    * @param important_flg:boolean
    * @return boolean
    */
    public function subItem(int $order, int $count=1, bool $important_flg=false): bool
    {
        // 消費可否チェック
        // 存在しない or アイテムカウントがnull且つ大切なものフラグがfalse
        if(
            !isset($this->items[$order]) ||
            (is_null($this->items[$order]['count']) && !$important_flg)
        ){
            return false;
        }
        if($important_flg){
            // 大切なものを消費
            unset($this->items[$order]);
            $this->items = array_values($this->items);
            return true;
        }
        // 通常アイテムの消費
        if($count < 1){
            $count = 1; # 最小値
        }
        // 消費個数以上あれば減算処理
        if($this->items[$order]['count'] >= $count){
            // 減算処理
            $this->items[$order]['count'] -= $count;
            if($this->items[$order]['count'] < 1){
                // 0個になればアイテム欄から取り除く
                unset($this->items[$order]);
                $this->items = array_values($this->items);
            }
            return true;
        }else{
            return false;
        }
    }

}
