<?php

/**
* バトルコントローラー用トレイト
*/
trait BattleControllerTrait
{

    /**
    * 引き継ぎ処理
    * @return void
    */
    protected function inheritance()
    {
        // バトル状態の引き継ぎ
        if(isset($_SESSION['__data']['battle_state'])){
            // グローバルにセット
            setBattleState(
                unserializeObject($_SESSION['__data']['battle_state'])
            );
            // ターン最初の状態へ初期化
            battle_state()->turnInit();
            // 描画用ポケモンをセット（味方・敵）
            battle_state()->setBefore();
            // シリアライズでリンク切れしているため、味方のオブジェクトを再セット(へんしん状態を考慮)
            $order = battle_state()->getOrder();
            battle_state()->setFriend(
                battle_state()->getTransform('friend') ?? player()->getPartner($order)
            );
        }
    }

    /**
    * 次のターンへの判定処理
    * @return boolean
    */
    private function nextTurn()
    {
        // アクション未選択であれば処理を行わない
        if(!battle_state()->isJudge()){
            return false;
        }
        // ひんしポケモンがでた場合の処理
        if(battle_state()->isFainting()){
            $this->judgment();
            return false;
        }
        // チャージ中、反動有り、あばれる状態なら再度アクション実行
        if(
            $this->chargeNow() ||
            friend()->checkSc('ScRecoil') ||
            friend()->checkSc('ScThrash')
        ){
            $this->branch();
            return true;
        }else{
            setMessage('行動を選択してください');
            return false;
        }
    }

    /**
    * 行動不可（チャージ中）の判定
    *
    * @return boolean (true:行動不可, false:行動可)
    */
    private function chargeNow()
    {
        $sc = friend()->getSc();
        // チャージ中なら行動選択不可
        if(isset($sc['ScCharge'])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * バトル結果判定
    * @return void
    */
    private function judgment(): void
    {
        // 味方がひんし状態になった
        if(battle_state()->isFainting('friend')){
            // 戦闘可能なパーティーを確認
            if(player()->isFightParty()){
                // パーティーが残っている
                if(battle_state()->isFainting('enemy')){
                    // 相手が瀕死状態 → バトル終了
                    $this->judgmentWin();
                }else{
                    // 相手が瀕死状態ではない → ポケモン交代の確認
                    $msg_id = issueMsgId();
                    setMessage('次のポケモンを使いますか？', $msg_id);
                    // レスポンスデータをセット
                    setResponse([
                        'toggle' => 'modal',
                        'target' => '#'.$msg_id.'-modal'
                    ], $msg_id);
                    // モーダル用のレスポンスをセット
                    setModal([
                        'id' => $msg_id,
                        'modal' => 'change-or-run'
                    ]);
                    waitForceModal($msg_id);
                }
            }else{
                // 全滅（負け）
                $this->judgmentLose();
            }
        }else if(battle_state()->isFainting('enemy')){
            // 相手がひんし状態になった（味方はひんし状態ではない）
            // 勝ち
            $this->judgmentWin();
        }
    }

    /**
    * バトル結果（負け）
    * @return void
    */
    private function judgmentLose()
    {
        // 全滅
        setMessage(player()->getName().'は、目の前が真っ暗になった');
        // バトル終了判定用メッセージの格納
        setEmptyMessage('battle-end');
    }

    /**
    * バトル結果（勝ち）
    * @return void
    */
    private function judgmentWin()
    {
        // 経験値の計算
        $party = player()->getParty();
        $order = battle_state()->getOrder();
        // パーティー取得
        $exp = $this->calExp(friend(), enemy());
        // 経験値をポケモンにセット
        $party[$order]->setExp($exp);
        // 努力値を獲得
        $party[$order]->setEv(enemy()->getRewardEv());
        // もしポケモンが「へんしん状態」であれば変更後の状態を引き継ぎ
        if(friend()->checkSc('ScTransform')){
            friend()->judgmentTransform($party[$order]);
        }
        // 散らばったお金の取得
        $money = battle_state()->getMoney();
        if($money){
            setMessage(player()->getName().'は、'.$money.'円拾った');
            player()->addMoney($money);
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
    * デストラクタ直前の処理
    * @return void
    */
    private function checkBeforeDestruct()
    {
        $transform = battle_state()->getTransform('friend');
        // もし「へんしん状態」であれば、残HPと状態異常を元ポケモンに反映
        if($transform){
            $order = battle_state()->getOrder();
            player()->getParty()[$order]
            ->mirroringTransform($transform);
        }
    }

}
