<?php
// 敵ポケモンのみの行動（にげる・アイテム・捕獲）
trait ServiceBattleEnemyTurnTrait
{

    /**
    * 相手のみのターン処理
    * @return void
    */
    protected function enemyTurn(): void
    {
        // 相手ポケモンの怒り解除
        enemy()->initSc('ScRage');
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
        // 敵ポケモンの攻撃
        $this->attack(enemy(), friend(), $this->aiSelectMove());
        // ひんしチェック
        return enemy()->isFainting() || friend()->isFainting();
    }

}
