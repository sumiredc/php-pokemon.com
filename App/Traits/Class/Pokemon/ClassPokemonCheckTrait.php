<?php
trait ClassPokemonCheckTrait
{

    /**
    * 状態変化の確認用メソッド
    * @param string $key
    * @return void
    */
    public function checkSc($key)
    {
        if(isset($this->sc[$key])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * チャージ技の確認メソッド
    * @param string $move_class
    * @return void
    */
    public function checkChargeMove($move_class)
    {
        if(
            isset($this->sc['ScCharge']) &&
            $this->sc['ScCharge']['param'] === $move_class
        ){
            return true;
        }else{
            return false;
        }
    }

    /**
    * 現在のレベルで覚えられる技があるか確認する処理
    *
    * @return void
    */
    protected function checkMove()
    {
        // レベルアップして覚えられる技があれば習得する
        $level_move_keys = array_keys(array_column($this->level_move, 0), $this->level);
        foreach($level_move_keys as $key){
            $move_class = $this->level_move[$key][1];
            // 覚えようとしている技（クラス）が存在かつ重複していないか
            if(!in_array($move_class, array_column($this->move, 'class'), true)){
                // インスタンス化
                $move = new $move_class();
                // 技クラスをセット
                $this->setMove($move);

                $this->setMessage($move->getName().'を覚えた！', 'success');
            }
        }
    }

    /**
    * 使用できる技があるかどうか調べる処理
    *
    * @return boolean
    */
    public function checkUsedMove()
    {
        foreach($this->move as $move){
            // PPが残っているか確認
            if(!empty($move['remaining'])){
                return true;
            }
        }
        return false;
    }
}
