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
    protected function dafaultLastMoves() :void
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
    public function getLastMove(string $position = 'all')
    {
        return $this->last_moves[$position];
    }

    /**
    * 最後に使用した技(クラス)の格納
    * @param position:string::friend|enemy
    * @param move:object|string::Move
    * @return void
    */
    public function setLastMove(string $position, $move)
    {
        // オブジェクト・文字列（クラス名）両方を許可
        if(is_object($move)){
            $class = get_class($move);
        }else{
            $class = $move;
        }
        $this->last_moves[$position] = $class;
        $this->last_moves['all'] = $class;
    }

}
