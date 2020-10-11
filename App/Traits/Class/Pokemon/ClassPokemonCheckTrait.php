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
    * 現在のレベルで覚えられる技があるか確認する処理
    *
    * @return integer
    */
    protected function checkMove()
    {
        // レベルアップして覚えられる技があれば習得する
        $level_move_keys = array_keys(array_column($this->level_move, 0), $this->level);
        foreach($level_move_keys as $key){
            $move_class = $this->level_move[$key][1];
            // 覚えようとしている技（クラス）が存在かつ重複していないか
            if(class_exists($move_class) && !in_array($move_class, $this->move, true)){
                // 技クラスをセット
                $this->setMove($move_class);
                // インスタンス化
                $move = new $move_class();
                $this->setMessage($move->getName().'を覚えた！', 'success');
            }
        }
    }

}