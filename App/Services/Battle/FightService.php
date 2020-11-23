<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackAfterTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCheckTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleEnemyAiTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleOrderGenelatorTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleExTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCalTrait.php');

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
    * @var integer
    */
    protected $move_number;

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
            ['enemy', 'friend', $this->selectEnemyMove()],
        );
        // 攻撃処理
        if($this->actionAttack($orders)){
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
            return new MoveStruggle;
        }else{
            // 配列で取得
            $move = friend()->getMove(request('param'), 'array');
            // 残PPがなければ「わるあがき」を返却
            if($move['remaining'] <= 0){
                return new MoveStruggle;
            }
            // 技オブジェクトを返却
            return new $move['class'];
        }
    }

    /**
    * 相手ポケモンの技選択
    *
    * @return object Move
    */
    private function selectEnemyMove()
    {
        // AIで技選択
        $move = $this->aiSelectMove();
        // 敵の技をインスタンス化
        // return new $ai['class']($ai['remaining'], $ai['correction']);
        return new $move;
    }

    /**
    * 行動順に攻撃処理
    *
    * @return boolean (false: ひんしポケモン有り)
    */
    private function actionAttack($orders)
    {
        foreach($orders as list($atk_position, $def_position, $move)){
            // positionから該当するポケモンを呼び出し
            $atk = $atk_position();
            $def = $def_position();
            // 攻撃ポケモンの怒り解除
            $atk->releaseSc('ScRage');
            // 攻撃(返り値に使用した技を受け取る)
            $attack_move = $this->attack($atk, $def, $move);
            // 最後に使用した技を格納
            battle_state()->setLastMove($atk_position, $attack_move);
            // バトル終了のレスポンスチェック（交代技など）
            if(getResponse('end')){
                break;
            }
            // ひんしチェック
            if(battle_state()->isFainting()){
                $result = false;
                break;
            }
        } # endforeach
        // 結果返却
        return $result ?? true;
    }

}
