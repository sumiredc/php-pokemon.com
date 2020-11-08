<?php
trait ClassPokemonReleaseTrait
{
    /**
    * リフレッシュ処理（ランク・状態変化をリセット）
    *
    * @return void
    */
    public function releaseBattleStatsAll()
    {
        $this->releaseSc();
        $this->releaseRank();
    }

    /**
    * 状態異常の解除
    *
    * @return void
    */
    public function releaseSa()
    {
        if($this->getSa() !== 'SaFainting'){
            $this->sa = [];
        }
    }

    /**
    * 状態変化の解除
    *
    * @param string $class
    * @return void
    */
    public function releaseSc($class='')
    {
        if(empty($class)){
            // 全解除
            $this->sc = [];
        }else{
            // 指定された状態変化の解除
            unset($this->sc[$class]);
        }
    }

    /**
    * ランク補正の解除
    *
    * @param string $param
    * @return void
    */
    public function releaseRank($param='')
    {
        if($param && isset($this->rank[$param])){
            // 指定されたランクを解除
            $this->rank[$param] = 0;
        }else{
            // 全解除
            $this->defaultRank();
        }
    }
}
