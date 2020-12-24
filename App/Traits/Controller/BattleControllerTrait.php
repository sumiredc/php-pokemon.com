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
            // シリアライズでリンク切れしているため、味方のオブジェクトを再セット
            $order = battle_state()->getOrder();
            battle_state()->setFriend(
                player()->getPartner($order)
            );
            // もしトレーナー戦であれば、相手のオブジェクトも再セット
            if(battle_state()->isMode('trainer')){
                $trainer_order = battle_state()->getTrainerOrder();
                battle_state()->setEnemy(
                    trainer()->getPartner($trainer_order)
                );
            }
        }
    }

    /**
    * 次のターンへの判定処理
    * @return boolean
    */
    private function nextTurn(): bool
    {
        // アクション未選択であれば処理を行わない
        if(!battle_state()->isJudge()){
            response()->setEmptyMessage();
            return false;
        }
        // ひんしポケモンがでた場合の処理
        if(
            enemy()->isFainting() ||
            friend()->isFainting()
        ){
            $this->judgment();
            return false;
        }
        // チャージ中、反動有り、あばれる状態なら再度アクション実行
        if(
            $this->chargeNow() ||
            friend()->isSc('ScRecoil') ||
            friend()->isSc('ScThrash')
        ){
            $this->branch();
            return true;
        }else{
            // 行動選択へ
            response()->setEmptyMessage();
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
        // チャージ中なら行動選択不可
        if(friend()->isSc('ScCharge')){
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
        if(friend()->isFainting()){
            // 戦闘可能なパーティーを確認
            if(player()->isFightParty()){
                // パーティーが残っている
                if(enemy()->isFainting()){
                    // 相手が瀕死状態 → バトル終了
                    $this->judgmentWin();
                }else{
                    // 相手が瀕死状態ではない → ポケモン交代の確認
                    $msg_id = response()->issueMsgId();
                    response()->setMessage('次のポケモンを使いますか？', $msg_id);
                    // レスポンスデータをセット
                    response()->setResponse([
                        'toggle' => 'modal',
                        'target' => '#'.$msg_id.'-modal'
                    ], $msg_id);
                    // モーダル用のレスポンスをセット
                    response()->setModal([
                        'id' => $msg_id,
                        'modal' => 'change-or-run'
                    ]);
                    response()->waitForceModal($msg_id);
                }
            }else{
                // 全滅（負け）
                $this->judgmentLose();
            }
        }else if(enemy()->isFainting()){
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
        // トレーナー戦
        if(battle_state()->isMode('trainer')){
            response()->setMessage(trainer()->getLine('win'));
        }
        // お小遣いの半額を失う
        player()->loseMoney();
        // 全滅
        response()->setMessage(player()->getName().'は、目の前が真っ暗になった...');
        // バトル終了判定用メッセージの格納
        response()->setEmptyMessage('battle-end');
    }

    /**
    * バトル結果（勝ち）
    * @return void
    */
    private function judgmentWin()
    {
        $party = player()->getParty();
        // 経験値がもらえるポケモンに経験値を割り振り
        $orders = battle_state()->getEntitledExpOrders();
        foreach($orders as $order){
            // 経験値の計算
            $exp = $this->calExp($party[$order], enemy(), count($orders));
            // 経験値をポケモンにセット
            $party[$order]->setExp($exp);
            // 努力値を獲得
            $party[$order]->setEv(enemy('REWARD_EV'));
        }
        // トレーナー戦の場合は、次のポケモンを選出
        if(battle_state()->isMode('trainer')){
            $msg_id = response()->issueMsgId();
            if(battle_state()->nextOrder()){
                response()->setMessage(trainer()->getPrefixName().'は、'.enemy('NAME').'を繰り出してきた', $msg_id);
                response()->setResponse([
                    'action' => 'change-out',
                    'target' => 'enemy',
                    'param' => json_encode([
                        'base64' => enemy()->base64(),
                        'name' => enemy('NAME'),
                        'level' => enemy()->getLevel(),
                        'hp_max' => enemy()->getStats('H'),
                        'hp_now' => enemy()->getRemainingHp(),
                        'hp_per' => enemy()->getRemainingHp('per'),
                        'sa' => enemy()->getSaName(),
                        'sa_color' => enemy()->getSaColor(),
                    ])
                ], $msg_id);
                // 次のポケモンのバトル状態を初期化
                enemy()->initBattleStats();
                battle_state()->changeInit('enemy');
                // 行動選択へ
                response()->setEmptyMessage();

            }else{
                // 勝利演出
                response()->setMessage(trainer()->getPrefixName().'との勝負に勝った', $msg_id);
                response()->setResponse([
                    'action' => 'show-trainer',
                    'target' => 'enemy',
                ], $msg_id);
                // 勝利メッセージ
                response()->setMessage(trainer()->getLine('lose'));
                // 賞金
                $money = trainer()->getMoney();
                response()->setMessage(player()->getName().'は、賞金として'.$money.'円を受け取った！');
                player()->addMoney($money);
                // 勝利時の最終処理
                $this->judgmentWinLast();
            }
        }else{
            // 勝利時の最終処理
            $this->judgmentWinLast();
        }
    }

    /**
    * バトル結果（勝ち）
    * @return void
    */
    private function judgmentWinLast()
    {
        // 散らばったお金の取得
        $money = battle_state()->getMoney();
        if($money){
            response()->setMessage(player()->getName().'は、'.$money.'円拾った！');
            player()->addMoney($money);
        }
        // バトル終了判定用メッセージの格納
        response()->setEmptyMessage('battle-end');
    }

    /**
    * 経験値の計算
    * (EXP / count × LM^2.5 + 1)
    * @var EXP 倒されたポケモンのレベル × 倒されたポケモンの基礎経験値 ÷ 5
    * @var count 戦闘に参加したポケモンの数
    * @var LM レベル補正 (2L + 10) / (L + Lp + 10)
    * @var L 倒されたポケモン($lose)のレベル
    * @var Lp 倒したポケモン($win)のレベル
    * @param win:object::Pokemon
    * @param lose:object::Pokeomo
    * @param count:integer
    * @return integer
    */
    protected function calExp(object $win, object $lose, int $count): int
    {
        // EXP
        $exp = $lose->getLevel() * $lose::BASE_EXP / 5;
        // レベル補正
        $lm = (2 * $lose->getLevel() + 10) / ($lose->getLevel() + $win->getLevel() + 10);
        // 返り値の型指定を使って、経験値の計算結果を整数（切り捨て）で返却
        return $exp / $count * $lm ** 2.5 + 1;
    }

}
