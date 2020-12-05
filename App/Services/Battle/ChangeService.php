<?php
// 親クラス
require_once(app_path('Services').'Service.php');
// トレイト
require_once(app_path('Traits.Service.Battle').'ServiceBattleAttackTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleEnemyTurnTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleAttackAfterTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleCheckTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleEnemyAiTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleOrderGenelatorTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleExTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleCalTrait.php');

/**
* 交代
*/
class ChangeService extends Service
{

    use ServiceBattleAttackTrait;
    use ServiceBattleEnemyTurnTrait;
    use ServiceBattleAttackAfterTrait;
    use ServiceBattleCheckTrait;
    use ServiceBattleEnemyAiTrait;
    use ServiceBattleOrderGenelatorTrait;
    use ServiceBattleExTrait;
    use ServiceBattleCalTrait;

    /**
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * @return void
    */
    public function execute()
    {
        // バリデーション
        if(!$this->validation()){
            return;
        }
        // 瀕死チェック後に交代処理を行う（friendのポケモンが入れ替わるため）
        if(friend()->isFainting()){
            // 瀕死状態からの交代
            $this->change();
            // モーダル初期化
            response()->initForceModal();
            // 判定不要処理
            battle_state()->judgeFalse();
        }else{
            // 通常の交代処理
            $this->change();
            // 相手のターン処理
            $this->enemyTurn();
        }
    }

    /**
    * 検証
    * @return bool
    */
    private function validation(): bool
    {
        /**
        * 現在と同じ → false
        * 存在しない → false
        * ひんし → false
        */
        $partner = player()->getPartner(request('order'));
        if(
            request('order') === battle_state()->getOrder() ||
            empty($partner) ||
            $partner->isFainting()
        ){
            return false;
        }
        return true;
    }

    /**
    * 交代処理
    * @return void
    */
    private function change(): void
    {
        $partner = player()->getPartner(request('order'));
        // 現在のバトルポケモンのバトルステータス関係を初期化
        friend()->initBattleStats();
        battle_state()->changeInit('friend');
        // ポケモンを戻す演出処理(味方が戦闘不能状態でなければ)
        if(friend()->isFight()){
            $msg_id1 = response()->issueMsgId();
            response()->setMessage(friend()->getNickname().'、戻れ！', $msg_id1);
            response()->setResponse([
                'action' => 'change-in',
                'target' => 'friend'
            ], $msg_id1);
        }
        // バトル中のポケモンを交代してポケモン番号を変更
        battle_state()->setFriend($partner, true);
        // 交代後のポケモンを繰り出す演出処理
        $msg_id2 = response()->issueMsgId();
        response()->setMessage('ゆけっ！'.friend()->getNickname().'！', $msg_id2);
        response()->setResponse([
            'action' => 'change-out',
            'target' => 'friend',
            'param' => json_encode([
                'base64' => $partner->base64('back'),
                'name' => $partner->getNickname(),
                'level' => $partner->getLevel(),
                'hp_max' => $partner->getStats('H'),
                'hp_now' => $partner->getRemainingHp(),
                'hp_per' => $partner->getRemainingHp('per'),
                'hp_color' => $partner->getRemainingHp('color'),
                'sa' => $partner->getSaName(),
                'sa_color' => $partner->getSaColor(),
                'exp' => $partner->getPerCompNexExp(),
            ])
        ], $msg_id2);
    }

}
