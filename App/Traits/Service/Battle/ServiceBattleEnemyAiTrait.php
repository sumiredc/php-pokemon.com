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
        // チャージ中ならチャージ技を返却
        if($this->enemy->checkSc('ScCharge')){
            return $this->enemy
            ->getChargeMove();
        }
        // あばれる中ならあばれる技を返却
        if($this->enemy->checkSc('ScThrash')){
            return $this->enemy
            ->getSc('ScThrash', false, true);
        }
        // 技の一覧を配列形式で取得
        $move = $this->enemy
        ->getMove(null, 'array');
        // ランダムで1つ返却
        return $move[array_rand($move)];
    }

}
