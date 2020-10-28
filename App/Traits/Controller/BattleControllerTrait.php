<?php

/**
 * バトルコントローラー用トレイト
 */
trait BattleControllerTrait
{

    // /**
    // * ポケモン情報の引き継ぎ
    // *
    // * @param Pokemon::export:array $pokemon
    // * @return void
    // */
    // protected function takeOverPokemon($pokemon)
    // {
    //     $this->pokemon = $this->unserializeObject($pokemon);
    //     // 前ターンの状態をプロパティに格納
    //     $this->before['friend'] = clone $this->pokemon;
    // }
    //
    // /**
    // * 相手ポケモンの引き継ぎ
    // *
    // * @param Pokemon::export:array $enemy
    // * @return void
    // */
    // protected function takeOverEnemy($enemy)
    // {
    //     if(!empty($enemy)){
    //         $this->enemy = $this->unserializeObject($enemy);
    //         // 前ターンの状態をプロパティに格納
    //         $this->before['enemy'] = clone $this->enemy;
    //     }
    // }

    /**
    * 敵ポケモン情報の取得
    *
    * @return Pokemon:object
    */
    public function getEnemy()
    {
        return $this->enemy;
    }

    /**
    * 行動不可（チャージ中）の判定
    *
    * @return boolean (true:行動不可, false:行動可)
    */
    private function chargeNow()
    {
        $sc = $this->pokemon
        ->getSc();
        // チャージ中なら行動選択不可
        if(isset($sc['ScCharge'])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * 前のターンの残りHPを取得（HPバー用）
    *
    * @param Pokemon:object $pokemon
    * @return numeric
    */
    public function getBefore($pokemon)
    {
        return $this->before[$pokemon->getPosition()];
    }

    /**
    * バトル結果判定
    *
    * @return void
    */
    private function judgment()
    {
        if($this->fainting['friend']){
            // 味方がひんし状態になった
            $this->setMessage('目の前が真っ暗になった');
        }else{
            // 相手がひんし状態になった（味方はひんし状態ではない）
            // 経験値の計算
            $exp = $this->calExp($this->pokemon, $this->enemy);
            // 経験値をポケモンにセット
            $this->pokemon
            ->setExp($exp);
            // 努力値を獲得
            $this->pokemon
            ->setEv($this->enemy->getRewardEv());
            // ポケモンに溜まったメッセージとレスポンスを取得
            $this->setMessage($this->pokemon->getMessages());
            $this->setResponse($this->pokemon->getResponses());
            $this->setModal($this->pokemon->getModals(), true);
            // 全レスポンスを初期化
            $this->pokemon
            ->resetResponsesAll();
        }
        // バトル終了判定用メッセージの格納
        $this->setEmptyMessage('battle-end');
    }

    /**
    * 経験値の計算
    * (EXP × LM^2.5 + 1)
    *
    * @var EXP 倒されたポケモンのレベル × 倒されたポケモンの基礎経験値 ÷ 5
    * @var LM レベル補正 (2L + 10) / (L + Lp + 10)
    * @var L 倒されたポケモン($lose)のレベル
    * @var Lp 倒したポケモン($win)のレベル
    *
    * @param Pokemon:object $win
    * @param Pokeomo:object $lose
    * @return integer
    */
    protected function calExp($win, $lose)
    {
        // EXP
        $exp = $lose->getLevel() * $lose->getBaseExp() / 5;
        // レベル補正
        $lm = (2 * $lose->getLevel() + 10) / ($lose->getLevel() + $win->getLevel() + 10);
        // 経験値の計算結果を整数（切り捨て）で返却
        return (int)($exp * $lm ** 2.5 + 1);
    }

}
