<?php

/**
 * ホームコントローラー用トレイト
 */
trait HomeControllerTrait
{
    /**
    * ポケモン情報の引き継ぎ
    *
    * @return object|array
    */
    protected function takeOverPokemon($pokemon)
    {
        if(isset($pokemon['class_name'])){
            // 旧処理
            $class = $pokemon['class_name'];
            $this->pokemon = new $class($pokemon);
        }else{
            $this->pokemon = $this->unserializeObject($pokemon);
        }
    }
}
