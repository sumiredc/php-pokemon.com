<?php
trait ClassPokemonInitTrait
{

    /**
    * 個体値の初期化
    * @return void
    */
    protected function initIv(): void
    {
        $this->iv = array_map(function(){
            // 0〜31の間でランダムの数値を割り振る
            return random_int(0, 31);
        }, config('pokemon.stats.default'));
    }

    /**
    * 努力値の初期化
    * @return void
    */
    protected function initEv(): void
    {
        $this->ev = config('pokemon.stats.default');
    }

    /**
    * 状態異常の解除(瀕死を除く)
    * @return void
    */
    public function initSa(): void
    {
        if(!isset($this->sa['SaFainting'])){
            $this->sa = [];
        }
    }

}
