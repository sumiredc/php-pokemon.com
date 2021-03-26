<?php
trait ClassPokeboxBoxTrait
{

    /**
    * ボックスを選択状態にする(起動)
    * @param box_number:integer
    * @return boolean
    */
    public function selectBox(int $box_number): bool
    {
        if(isset($this->pokebox[$box_number])){
            $this->selected = $box_number;
            return true;
        }else{
            return false;
        }
    }

    /**
    * ボックスの存在チェック
    * @param box_number:integer
    * @return boolean
    */
    public function isBox($box_number): bool
    {
        if(isset($this->pokebox[$box_number])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * 現在のボックスの空き確認
    * @return boolean
    */
    public function isSelectedBoxSpace(): bool
    {
        if(count($this->pokebox[$this->selected]) >= config('pokebox.max')){
            return false;
        }else{
            return true;
        }
    }

    /**
    * ボックス内のポケモン数を取得
    * @param box_number:integer
    * @return int
    */
    public function getAmountUsed($box_number): int
    {
        return count($this->pokebox[$box_number]);
    }

    /**
    * ボックスの追加
    * @return integer
    */
    public function addBox(): int
    {
        $this->pokebox[] = [];
        // 追加したボックス番号を返却
        return array_key_last($this->pokebox);
    }

    /**
    * 選択中のボックスへアクセス（復号化して返却）
    * @param serialize:boolean
    * @return array
    */
    public function accessSelectedBox(bool $serialize=true): array
    {
        if($serialize){
            // 復号化して返却
            return array_map(function($pokemon){
                return unserializeObject($pokemon['object']);
            }, $this->pokebox[$this->selected] ?? []);
        }else{
            // 復号化せずに返却
            return $this->pokebox[$this->selected];
        }
    }

    /**
    * 選択中のボックス(実番号)を返却
    * @return integer|null
    */
    public function getSelectedBox()
    {
        return $this->selected;
    }

    /**
    * 選択中のボックス番号(表記)を返却
    * @return integer|false
    */
    public function getSelectedBoxNumber()
    {
        if(is_null($this->selected)){
            return false;
        }else{
            return $this->selected + 1;
        }
    }

}
