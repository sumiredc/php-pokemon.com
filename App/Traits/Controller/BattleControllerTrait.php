<?php

/**
 * バトルコントローラー用トレイト
 */
trait BattleControllerTrait
{

    /**
    * 味方ポケモン情報の取得
    *
    * @return object
    */
    public function getPokemon()
    {
        return $this->pokemon;
    }

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
    * バトル状態の取得
    *
    * @return object::BattleState
    */
    public function getBattleState()
    {
        return $this->battle_state;
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
            setMessage('目の前が真っ暗になった');
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
        }
        // バトル終了判定用メッセージの格納
        setEmptyMessage('battle-end');
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

    /**
    * 引き継ぎ処理
    * @return void
    */
    protected function inheritance()
    {
        // バトル状態の引き継ぎ
        if(isset($_SESSION['__data']['battle_state'])){
            $this->battle_state = unserializeObject($_SESSION['__data']['battle_state']);
            // ターン最初の状態へ初期化
            $this->battle_state
            ->turnInit();
        }else{
            $this->battle_state = new BattleState;
        }
        // ポケモン番号の引き継ぎ
        $this->order = $_SESSION['__data']['order'];
        // // パーティーの引き継ぎ
        // $this->party = unserializeObject($_SESSION['__data']['party']);
        // 敵ポケモンの引き継ぎ
        if(isset($_SESSION['__data']['enemy'])){
            $this->enemy = unserializeObject($_SESSION['__data']['enemy']);
            // 前ターンの状態をプロパティに格納
            $this->before['enemy'] = clone $this->enemy;
        }
        // 戦闘中のポケモンをプロパティにセット
        $this->pokemon = $this->party[$this->order];
        // 前ターンの状態をプロパティに格納
        $this->before['friend'] = clone $this->pokemon;
    }

    /**
    * 次のターンへの判定処理
    *
    * @return boolean
    */
    private function nextTurn()
    {
        // ひんしポケモンがでた場合の処理
        if($this->fainting['enemy'] || $this->fainting['friend']){
            $this->judgment();
            return false;
        }
        // チャージ中、反動有り、あばれる状態なら再度アクション実行
        if(
            $this->chargeNow() ||
            $this->pokemon->checkSc('ScRecoil') ||
            $this->pokemon->checkSc('ScThrash')
        ){
            $this->branch();
            return true;
        }else{
            setMessage('行動を選択してください');
            return false;
        }
    }

}
