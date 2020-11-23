<?php
// 敵ポケモンのみの行動（にげる・アイテム・捕獲）
trait ServiceBattleEnemyTurnTrait
{

    /**
    * 相手のみのターン処理
    * @return void
    */
    protected function enemyTurn()
    {
        // 相手ポケモンの怒り解除
        enemy()->releaseSc('ScRage');
        // 相手ポケモンの攻撃
        if($this->enemyAttack()){
            // 行動後の状態異常・変化をチェック
            $this->afterCheck();
        }
        // フィールドのカウントを進める
        battle_state()->goTurnFields();
    }

    /**
    * 相手の攻撃
    * @return boolean
    */
    private function enemyAttack(): bool
    {
        // AIで技選択
        $move_class = $this->aiSelectMove();
        // 敵の技をインスタンス化
        // $move = new $ai['class']($ai['remaining'], $ai['correction']);
        $move = new $move_class;
        // 敵ポケモンの攻撃
        $this->attack(enemy(), friend(), $move);
        // ひんしチェック
        if(battle_state()->isFainting()){
            return false;
        }
        return true;
    }

}
