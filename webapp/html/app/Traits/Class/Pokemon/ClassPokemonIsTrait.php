<?php
trait ClassPokemonIsTrait
{

    /**
    * 現在のレベルで覚えられる技があるか確認する処理
    * @return void
    */
    public function isLevelMove()
    {
        // レベルアップして覚えられる技があれば習得する
        $level_move_keys = array_keys(
            array_column(static::LEVEL_MOVE, 0),
            $this->level
        );
        foreach($level_move_keys as $key){
            $move = static::LEVEL_MOVE[$key][1];
            // 技習得処理
            $this->actionLearnMove($move);
        }
    }

    /**
    * 技マシンで覚えられるかどうかの確認処理
    * @param item:string
    * @return boolean
    */
    public function isLearnMachineMove(string $item): bool
    {
        // アイテムクラスの存在チェック
        if(
            !class_exists($item) ||
            $item::CATEGORY !== 'machine' ||
            !defined($item.'::MOVE') ||
            !class_exists($item::MOVE)
        ){
            return false;
        }
        // 技の習得処理
        return $this->actionLearnMove($item::MOVE);
    }

    /**
    * 使用できる技があるかどうか調べる処理
    * @return boolean
    */
    public function isUsedMove(): bool
    {
        $move = array_filter($this->move, function($move){
            // 残PPが残っているものだけを抽出
            return !empty($move['remaining']);
        });
        return !empty($move);
    }

    /**
    * 戦闘可能かどうかの確認
    * @return boolean
    */
    public function isFight()
    {
        return $this->remaining_hp > 0;
    }

    /**
    * 戦闘不能の確認
    * @return boolean
    */
    public function isFainting()
    {
        return $this->remaining_hp <= 0;
    }

}
