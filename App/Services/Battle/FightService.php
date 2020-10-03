<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCheckTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleEnemyAiTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleOrderGenelatorTrait.php');

/**
 * バトル開始
 */
class FightService extends Service
{

    use ServiceBattleAttackTrait;
    use ServiceBattleCheckTrait;
    use ServiceBattleEnemyAiTrait;
    use ServiceBattleOrderGenelatorTrait;

    /**
    * @var object Pokemon
    */
    protected $pokemon;

    /**
    * @var object Pokemon
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
    public function __construct($pokemon, $enemy, $move_number)
    {
        $this->pokemon = $pokemon;
        $this->enemy = $enemy;
        $this->move_number = $move_number;
    }

    /**
    * @return void
    */
    public function excute()
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
        if(!$this->actionAttack($orders)){
            // どちらかがひんし状態になった
            $this->exportProperty('fainting');
            return;
        }
        // 行動後の状態異常・変化をチェック
        $this->afterCheck();
        // 指定したプロパティを返却
        $this->exportProperty('fainting');
    }

    /**
    * 選択された技を取得
    *
    * @return object Move
    */
    private function selectMove()
    {
        // 自ポケモンの技をインスタンス化
        if($this->move_number === ''){
            // 技が未選択の場合は「わるあがき」をセット
            return new Struggle;
        }else{
            return $this->pokemon
            ->getMove($this->move_number);
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
            // 攻撃
            $this->attack($atk, $def, $move);
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
