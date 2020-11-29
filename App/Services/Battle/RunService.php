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
 * にげる
 */
class RunService extends Service
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
        // にげるのカウントを進める
        battle_state()->run();
        if($this->checkRun()){
            // 逃走成功
            setMessage('上手く逃げ切れた！');
            // バトル終了判定用メッセージの格納
            setEmptyMessage('battle-end');
        }else{
            // 逃走失敗
            $msg_id = issueMsgId();
            setMessage('逃げられない！', $msg_id);
            if(friend()->isFight()){
                // 相手のターン処理
                $this->enemyTurn();
            }else{
                // ひんし状態での逃走失敗
                setResponse([
                    'toggle' => 'modal',
                    'target' => '#party-modal'
                ], $msg_id);
                setModal([
                    'id' => $msg_id,
                    'existing_modal' => '#party-modal' # 既存モーダルの使用
                ]);
                // 強制表示モーダルを待機状態にする
                waitForceModal($msg_id);
                // 判定不要処理
                battle_state()->judgeFalse();
            }
        }
        // バトルポケモンが瀕死状態なら、強制モーダルを初期化
        if(!friend()->isFight()){
            initForceModal();
        }
    }

    /**
    * にげる判定
    * F = (A × 128 / B) + 30 × C
    * Fを256で割った値 → 逃走成功率
    * @var A 味方ポケモンのすばやさ（ランク補正有り）
    * @var B 相手ポケモンのすばやさ（ランク補正無し）
    * @var C 逃走を試みた回数
    * @return boolean
    */
    private function checkRun()
    {
        // 味方の素早さを取得（ランク補正有り）
        $a = friend()->getStats('Speed', true);
        // 相手の素早さを取得（ランク補正無し）
        $b = enemy()->getStats('Speed');
        // 逃走を試みた回数
        $c = battle_state()->getRun();
        // 計算式への当てはめ
        $f = ($a * 128 / $b) + 30 * $c;
        // 確率計算
        if(round($f / 256, 2) * 100 >= random_int(1, 100)){
            return true;    # 逃走成功
        }else{
            return false;   # 逃走失敗
        }
    }

}
