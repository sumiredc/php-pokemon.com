<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleEnemyTurnTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackAfterTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCheckTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleEnemyAiTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleOrderGenelatorTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleExTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCalTrait.php');

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
        // バトルポケモンが瀕死状態なら、強制モーダルを初期化
        if(!friend()->isFight()){
            initForceModal();
        }
        // 交代処理
        if($this->change()){
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
            !$partner->isFight()
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
        friend()->releaseBattleStatsAll();
        battle_state()->changeInit('friend');
        // ポケモンを戻す演出処理
        $msg_id1 = issueMsgId();
        setMessage(friend()->getNickname().'、戻れ！', $msg_id1);
        setResponse([
            'action' => 'change-in',
            'target' => 'friend'
        ], $msg_id1);
        // バトル中のポケモンを交代してポケモン番号を変更
        battle_state()->setFriend($partner, true);
        // 交代後のポケモンを繰り出す演出処理
        $msg_id2 = issueMsgId();
        setMessage('ゆけっ！'.friend()->getNickname().'！', $msg_id2);
        setResponse([
            'action' => 'change-out',
            'target' => 'friend',
            'param' => json_encode([
                'class' => get_class($partner),
                'name' => $partner->getNickname(),
                'level' => $partner->getLevel(),
                'hp_max' => $partner->getStats('HP'),
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
