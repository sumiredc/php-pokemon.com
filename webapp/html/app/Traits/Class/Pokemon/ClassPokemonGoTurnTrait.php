<?php
trait ClassPokemonGoTurnTrait
{
    /**
    * ターンカウントをすすめる（状態異常）
    * @param release:boolean
    * @return void
    */
    public function goSaTurn(bool $release=true): void
    {
        // 状態異常クラスを取得
        $class = $this->getSa();
        switch ($class) {
            /**
            * ねむり
            */
            case 'SaSleep':
            // 残ターン数を1マイナス
            $this->sa[$class]--;
            // $releaseがtrueなら解除判定
            if(
                $release &&
                $this->sa[$class] <= 0
            ){
                $this->sa = [];
            }
            break;
            /**
            * もうどく
            */
            case 'SaBadPoison':
            // 経過ターン数を1プラス（最大15）
            if($this->sa[$class] <= 14){
                $this->sa[$class]++;
            }else{
                $this->sa[$class] = 15;
            }
            break;
        }
    }

    /**
    * ターンカウントをすすめる（状態変化）
    *
    * @param class:string
    * @param release:boolean
    * @return void
    */
    public function goScTurn(string $class, bool $release=true): void
    {
        // 状態変化を取得
        if($this->isSc($class)){
            // 残ターン数を1マイナス
            $this->sc[$class]['turn']--;
            // $releaseがtrueなら解除チェック
            if(
                $release &&
                $this->sc[$class]['turn'] <= 0
            ){
                // 指定された状態変化の解除
                unset($this->sc[$class]);
            }
        }
    }
}
