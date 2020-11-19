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
    * @param item:object|string
    * @return integer
    */
    public function getItemCount($item): int
    {
        // オブジェクトの場合はクラス化する
        if(is_object($item)){
            $item = get_class($item);
        }
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
            // アイテムをインスタンス化
            $item = new $row['class'];
            // アイテム番号を取得
            $order = array_search(
                $row['class'],
                array_column($this->items, 'class')
            );
            $carry[$item->getCategory()][] = [
                'item' => $item,
                'count' => $row['count'],
                'order' => $order,
            ];
            return $carry;
        }, $initial);
    }

    /**
    * アイテムの追加
    * @param item:object::Item
    * @param count:integer
    * @return boolean
    */
    public function addItem(object $item, $count=1): bool
    {
        if(is_null($item->getMax())){
            // 個数計算しないアイテムの場合はnullをセット
            $count = null;
        }else{
            // 数チェック
            if($count < 1){
                $count = 1; # 最小値
            }
            if($item->getMax() < $count){
                $count = $item->getMax(); # 最大値
            }
        }
        // アイテムのクラスを取得
        $class = get_class($item);
        // 現在所有しているかどうかの確認
        $key = array_search(
            $class,
            array_column($this->items, 'class')
        );
        if($key === false){
            // 所有していない
            $this->items[] = [
                'class' => $class,
                'count' => $count
            ];
            return true;
        }else{
            // 個数計算するアイテム且つ最大量を超過しなければ個数を加算
            if(
                !is_null($count) &&
                ($this->items[$key]['count'] + $count) <= $item->getMax()
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
