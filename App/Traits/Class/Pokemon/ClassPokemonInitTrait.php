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

    /**
    * トレーナーポケモン用の初期化
    * @param data:array
    * @return object::this
    */
    public function initTrainerPokemon(array $data): object
    {
        // 指定した技への書き換え
        if(isset($data['move'])){
            // 技が存在していれば、初期化して再セット
            $this->move = [];
            foreach($data['move'] as $move){
                $this->setMove($move);
            }
        }
        // 個体値の書き換え
        if(isset($data['iv'])){
            // もしポケモン個別で設定があれば、優先
            $this->iv = $data['iv'];
        }else{
            // オール10(標準)
            $this->iv = array_map(function(){
                return 10;
            }, $this->iv);
        }
        // 努力値の書き換え
        if(isset($data['ev'])){
            $this->ev = $data['ev'];
        }
        // 全回復状態にする
        $this->recovery();
        return $this;
    }

}
