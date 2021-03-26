<?php
/**==================================================================
* 技関係の処理
==================================================================**/
trait ClassBattleStateMoveTrait
{

    /**
    * 選択された技
    * @var array
    */
    private $selected_moves;

    /**
    * 最後に使用した技
    * @var array
    */
    private $last_moves;

    /**==================================================================
    * 選択された技
    ==================================================================**/
    /**
    * 間近に選択された技の初期値
    * @return void
    */
    protected function initSelectedMoves(): void
    {
        $this->selected_moves = [
            'friend' => '',
            'enemy' => '',
        ];
    }

    /**
    * 間近に選択された技の初期化(対象指定)
    * @param position:string::friend|enemy
    * @return void
    */
    public function resetSelectedMove(string $position): void
    {
        $this->selected_moves[$position] = '';
    }

    /**
    * 間近に選択された技(クラス)の取得
    * @param position:string::friend|enemy|all
    * @return string
    */
    public function getSelectedMove(string $position): string
    {
        return $this->selected_moves[$position];
    }

    /**
    * 間近に選択された技の格納
    * @param position:string::friend|enemy
    * @param move:string
    * @return void
    */
    public function setSelectedMove(string $position, string $move): void
    {
        if(class_exists($move)){
            $this->selected_moves[$position] = $move;
        }
    }

    /**==================================================================
    * 最後に使用した技
    ==================================================================**/
    /**
    * 最後に使用した技の初期値
    * @return void
    */
    protected function initLastMoves(): void
    {
        $this->last_moves = [
            'friend' => '',
            'enemy' => '',
        ];
    }

    /**
    * 最後に使用した技の初期化(対象指定)
    * @param position:string::friend|enemy
    * @return void
    */
    protected function resetLastMove(string $position): void
    {
        $this->last_moves[$position] = '';
    }

    /**
    * 最後に使用した技(クラス)の取得
    * @param position:string::friend|enemy|all
    * @return string
    */
    public function getLastMove(string $position): string
    {
        return $this->last_moves[$position];
    }

    /**
    * 最後に使用した技の格納
    * @param position:string::friend|enemy
    * @param move:string
    * @return void
    */
    public function setLastMove(string $position, string $move): void
    {
        if(class_exists($move)){
            $this->last_moves[$position] = $move;
        }
    }

}
