<?php

/**
 * ホームコントローラー用トレイト
 */
trait HomeControllerTrait
{
    /**
    * ポケモン情報の引き継ぎ
    *
    * @return object
    */
    protected function takeOverPokemon($pokemon)
    {
        try {
            $class = $pokemon['class_name'];
            $this->pokemon = new $class($pokemon);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
