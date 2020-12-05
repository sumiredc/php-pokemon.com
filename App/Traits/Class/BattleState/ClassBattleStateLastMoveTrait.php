<?php
/**==================================================================
* 最後に使用した技
==================================================================**/
trait ClassBattleStateLastMoveTrait
{

    /**
    * 最後に使用した技の初期値
    * @return void
    */
    protected function initLastMoves(): void
    {
        $this->last_moves = [
            'friend' => '',
            'enemy' => '',
            'all' => '',
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
    public function getLastMove(string $position = 'all'): string
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
            $this->last_moves['all'] = $move;
        }
    }

}
