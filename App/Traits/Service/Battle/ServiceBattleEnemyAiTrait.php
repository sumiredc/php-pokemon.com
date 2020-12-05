<?php
// 敵ポケモンの行動AI
trait ServiceBattleEnemyAiTrait
{
    /**
    * 技の選択
    * @return string
    */
    protected function aiSelectMove(): string
    {
        // 技の一覧を配列形式で取得
        $move_list = enemy()->getBattleMove();
        // チャージ状態・またはあばれる状態の確認
        if(enemy()->isSc('ScCharge')){
            // チャージ状態
            $class = enemy()->getChargeMove();
        }elseif(enemy()->isSc('ScThrash')){
            // あばれる状態
            $class = enemy()->getThrashMove();
        }
        // 技番号の抽出
        if(isset($class)){
            // 選択された技の添番を取得
            $order = array_search(
                $class,
                array_column($move_list, 'class'),
            );
            // もし技が見つからなければわるあがきを返却（念の為）
            if($order === false){
                return 'MoveStruggle';
            }
        }else{
            // PPが残っている技を抽出
            $move_list = array_filter($move_list, function($move){
                return $move['remaining'];
            });
            // 残PPが全て0の場合は「わるあがき」
            if(empty($move_list)){
                return 'MoveStruggle';
            }else{
                // ランダムで1つ取得
                $order = array_rand($move_list);
            }
        }
        // 技を返却（存在しなければわるあがきを返却※念の為）
        return $move_list[$order]['class'] ?? 'MoveStruggle';
    }
}
