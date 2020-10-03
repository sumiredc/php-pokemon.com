<?php
// 敵ポケモンの行動AI
trait ServiceBattleEnemyAiTrait
{
    /**
    * 技の選択
    *
    * @return string
    */
    protected function aiSelectMove()
    {
        $sc = $this->enemy->getSc();
        // チャージ中ならチャージ技を返却
        if(isset($sc['ScCharge'])){
            return $this->enemy
            ->getChargeMove();
        }
        // 技の一覧を配列形式で取得
        $move = $this->enemy
        ->getMove(null, 'array');
        // ランダムで1つ返却
        return $move[array_rand($move)];
    }

}
