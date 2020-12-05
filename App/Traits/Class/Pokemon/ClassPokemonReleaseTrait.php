<?php
trait ClassPokemonReleaseTrait
{
    // /**
    // * リフレッシュ処理（ランク・状態変化をリセット）
    // * @return void
    // */
    // public function releaseBattleStatsAll(): void
    // {
    //     $this->releaseSc();
    //     $this->releaseRank();
    // }
    //
    // /**
    // * 状態異常の解除(瀕死を除く)
    // * @return void
    // */
    // public function releaseSa(): void
    // {
    //     if($this->getSa() !== 'SaFainting'){
    //         $this->sa = [];
    //     }
    // }
    //
    // /**
    // * 状態変化の解除
    // * @param clsas:string
    // * @return void
    // */
    // public function releaseSc(string $class=''): void
    // {
    //     if(empty($class)){
    //         // 全解除
    //         $this->sc = [];
    //     }else{
    //         // 指定された状態変化の解除
    //         unset($this->sc[$class]);
    //     }
    // }
    //
    // /**
    // * ランク補正の解除
    // *
    // * @param key:string
    // * @return void
    // */
    // public function releaseRank($key=''): void
    // {
    //     if(isset($this->rank[$key])){
    //         // 指定されたランクを解除
    //         $this->rank[$key] = 0;
    //     }else{
    //         // 全解除
    //         $this->defaultRank();
    //     }
    // }

}
