<?php
/**
* 進化コントローラー用トレイト
*/
trait EvolveControllerTrait
{

    /**
    * 引き継ぎ処理
    * @return void
    */
    protected function inheritance()
    {
        $this->order = $this->selectEvolveTarget();
    }

    /**
    * 進化ポケモンの選出
    * @return object
    */
    protected function selectEvolveTarget()
    {
        // 技習得処理中であればセッションの値を返却
        if(
            isset($_SESSION['__data']['order']) &&
            request('action') === 'learn_move'
        ){
            return $_SESSION['__data']['order'];
        }else{
            $evolves = array_filter(player()->getParty(), function($pokemon){
                return $pokemon->getEvolveFlg();
            });
            // 進化対象のポケモンがいなければ終了
            if(empty($evolves)){
                return null;
            }else{
                return array_key_first($evolves);
            }
        }
    }

    /**
    * 味方ポケモン情報の取得
    * @return object
    */
    public function getPokemon()
    {
        return player()->getParty()[$this->order] ?? '';
    }

}
