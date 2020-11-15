<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackTrait.php');
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
    use ServiceBattleCheckTrait;
    use ServiceBattleEnemyAiTrait;
    use ServiceBattleOrderGenelatorTrait;
    use ServiceBattleExTrait;
    use ServiceBattleCalTrait;

    /**
    * @var object::Pokemon
    */
    protected $pokemon;

    /**
    * @var object::Pokemon
    */
    protected $enemy;

    /**
    * @var integer
    */
    protected $move_number;

    /**
    * ひんし状態の格納
    * @var array
    */
    protected $fainting = [
        'friend' => false,
        'enemy' => false,
    ];

    /**
    * @return void
    */
    public function __construct($pokemon, $enemy)
    {
        $this->pokemon = $pokemon;
        $this->enemy = $enemy;
        $this->battle_state = getBattleState();
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 技取得
        $p_move = $this->selectMove();
        $e_move = $this->selectEnemyMove();
        // 行動順の取得
        $orders = $this->orderMove(
            [$this->pokemon, $this->enemy, $p_move],
            [$this->enemy, $this->pokemon, $e_move],
        );
        // 攻撃処理
        if($this->actionAttack($orders)){
            // 行動後の状態異常・変化をチェック
            $this->afterCheck();
        }
        // フィールドのカウントを進める
        $this->battle_state
        ->goTurnFields();

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
            return new Struggle;
        }else{
            // 配列で取得
            $move = $this->pokemon
            ->getMove(request('param'), 'array');
            // 残PPがなければ「わるあがき」を返却
            if($move['remaining'] <= 0){
                return new Struggle;
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
        $ai = $this->aiSelectMove();
        // 敵の技をインスタンス化
        return new $ai['class']($ai['remaining'], $ai['correction']);
    }

    /**
    * 行動順に攻撃処理
    *
    * @return boolean (false: ひんしポケモン有り)
    */
    private function actionAttack($orders)
    {
        foreach($orders as list($atk, $def, $move)){
            // 攻撃ポケモンの怒り解除
            $atk->releaseSc('ScRage');
            // 先手が「へんしん」を使って成功した場合のオブジェクト置き換え処理
            if(!$def->getTransformFlg() && $def->checkSc('ScTransform')){
                // 防御ポケモンのへんしんフラグがfalse且つ、状態変化で「へんしん」がセットされている場合
                $def = $this->battle_state
                ->getTransform($def->getPosition());
            }
            // 攻撃(返り値に使用した技を受け取る)
            $attack_move = $this->attack($atk, $def, $move);
            // 最後に使用した技を格納
            $this->battle_state
            ->setLastMove($atk->getPosition(), $attack_move);
            // バトル終了のレスポンスチェック（交代技など）
            if(getResponse('end')){
                break;
            }
            // ひんしチェック
            $this->fainting = [
                $atk->getPosition() => $this->checkFainting($atk),
                $def->getPosition() => $this->checkFainting($def),
            ];
            // どちらかがひんし状態なら処理終了
            if($this->fainting['friend'] || $this->fainting['enemy']){
                $result = false;
                break;
            }
        } # endforeach
        // 結果返却
        return $result ?? true;
    }

    /**
    * 行動後のチェック処理
    *
    * @return void
    */
    private function afterCheck()
    {
        // 素早さで行動順を算出
        $order = $this->orderSpeed(
            [$this->pokemon, $this->enemy],
            [$this->enemy, $this->pokemon],
        );
        // 順番に処理
        foreach($order as list($atk, $def)){
            // ひんしチェック(開始時に行動側がひんし状態になっていないか確認)
            if($this->fainting[$atk->getPosition()]){
                // ひんし状態になった
                continue;
            }
            // 状態異常チェック
            $this->checkAfterSa($atk);
            // ひんし状況の格納
            $this->fainting[$atk->getPosition()] = $this->checkFainting($atk);
            // ひんしチェック
            if($this->fainting[$atk->getPosition()]){
                // どちらかがひんし状態になった
                continue;
            }
            // 状態変化チェック
            $this->checkAfterSc($atk, $def);
            // ひんし状況の格納
            $this->fainting = [
                $atk->getPosition() => $this->checkFainting($atk),
                $def->getPosition() => $this->checkFainting($def),
            ];
        } # endforeach
    }

}
