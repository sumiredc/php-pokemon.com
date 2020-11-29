<?php
trait ClassPokemonGoTurnTrait
{
    /**
    * ターンカウントをすすめる（状態異常）
    *
    * @param release:boolean
    * @return void
    */
    public function goSaTurn(bool $release=true)
    {
        // 状態異常クラスを取得
        $sa = $this->getSa();
        switch ($sa) {
            /**
            * ねむり
            */
            case 'SaSleep':
            // 残ターン数を1マイナス
            $this->sa[$sa]--;
            // $releaseがtrueなら解除判定
            if($release && ($this->sa[$sa] <= 0)){
                $this->sa = [];
            }
            break;
            /**
            * もうどく
            */
            case 'SaBadPoison':
            // 経過ターン数を1プラス（最大15）
            if($this->sa[$sa] <= 14){
                $this->sa[$sa]++;
            }else{
                $this->sa[$sa] = 15;
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
    public function goScTurn(string $class, bool $release=true)
    {
        // 状態変化を取得
        $sc = $this->getSc();
        if(isset($sc[$class])){
            // 残ターン数を1マイナス
            $this->sc[$class]['turn']--;
            // $releaseがtrueなら解除チェック
            if($release && ($this->sc[$class]['turn'] <= 0)){
                // 指定された状態変化の解除
                unset($this->sc[$class]);
            }
        }
    }
}
