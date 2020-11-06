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
        // 技の一覧を配列形式で取得
        $move_list = $this->enemy
        ->getMove(null, 'array');
        // チャージ状態・またはあばれる状態の確認
        if($this->enemy->checkSc('ScCharge')){
            // チャージ状態
            $class = $this->enemy
            ->getChargeMove();
        }elseif($this->enemy->checkSc('ScThrash')){
            // あばれる状態
            $class = $this->enemy
            ->getThrashMove();
        }
        // 技番号の抽出
        if(isset($class)){
            // 選択された技の添番を取得
            $num = array_search(
                $class,
                array_column($move_list, 'class'),
            );
        }else{
            // ランダムで1つ返却
            $num = array_rand($move_list);
        }
        // 技を返却
        return $move_list[$num];
    }

}
