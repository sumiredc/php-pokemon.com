<?php
// 親クラス
require_once(app_path('Services').'Service.php');
// トレイト
require_once(app_path('Traits.Service.Battle').'ServiceBattleAttackTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleAttackAfterTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleCheckTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleEnemyAiTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleOrderGenelatorTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleExTrait.php');
require_once(app_path('Traits.Service.Battle').'ServiceBattleCalTrait.php');

/**
 * バトル開始
 */
class FightService extends Service
{

    use ServiceBattleAttackTrait;
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
        // 技取得
        // 行動順の取得
        $orders = $this->orderMove(
            ['friend', 'enemy', $this->selectMove()],
            ['enemy', 'friend', $this->aiSelectMove()],
        );
        // 攻撃処理
        $fight = $this->actionAttack($orders);
        if($fight){
            // 行動後の状態異常・変化をチェック
            $this->afterCheck();
        }
        // フィールドのカウントを進める
        battle_state()->goTurnFields();
    }

    /**
    * 選択された技を取得
    *
    * @return object::Move
    */
    private function selectMove()
    {
        // 自ポケモンの技をインスタンス化
        if(request('param') === ''){
            // 技が未選択の場合は「わるあがき」を返却
            return 'MoveStruggle';
        }else{
            // 配列で取得
            $move = friend()->getBattleMove(request('param'));
            // 残PPがなければ「わるあがき」を返却
            if(
                empty($move) ||
                $move['remaining'] <= 0
            ){
                return 'MoveStruggle';
            }
            // 技クラスを返却
            return $move['class'];
        }
    }

    /**
    * 行動順に攻撃処理
    * @return boolean::false:ひんしポケモン有り
    */
    private function actionAttack($orders): bool
    {
        foreach($orders as list($atk_position, $def_position, $move)){
            // positionから該当するポケモンを呼び出し
            $atk = $atk_position();
            $def = $def_position();
            // 攻撃ポケモンの怒り解除
            $atk->initSc('ScRage');
            // 攻撃(返り値に使用した技を受け取る)
            $attack_move = $this->attack($atk, $def, $move);
            // 最後に使用した技を格納
            battle_state()->setLastMove($atk_position, $attack_move);
            // バトル終了のレスポンスチェック（交代技など）
            if(response()->getResponse('end')){
                break;
            }
            // ひんしチェック
            if(
                enemy()->isFainting() ||
                friend()->isFainting()
            ){
                $result = false;
                break;
            }
        } # endforeach
        // 結果返却
        return $result ?? true;
    }

}
