<?php
// 攻撃処理後の処理
trait ServiceBattleAttackAfterTrait
{
    /**
    * 行動後のチェック処理
    * @return void
    */
    private function afterCheck()
    {
        // 素早さで行動順を算出
        $order = $this->orderSpeed(
            ['friend', 'enemy'],
            ['enemy', 'friend'],
        );
        // 順番に処理
        foreach($order as list($atk_position, $def_position)){
            // positionから該当するポケモンを呼び出し
            $atk = $atk_position();
            $def = $def_position();
            // ひんしチェック(開始時に行動側がひんし状態になっていないか確認)
            if($atk->isFainting()){
                // ひんし状態になった（バインド状態を解除）
				$def->initSc('ScBind');
                continue;
            }
            // 状態異常チェック
            $this->checkAfterSa($atk);
            // ひんしチェック
            if(
                $atk->isFainting() ||
                $def->isFainting()
            ){
                // どちらかがひんし状態になった
				$atk->initSc('ScBind');
				$def->initSc('ScBind');
                continue;
            }
            // 状態変化チェック
            $this->checkAfterSc($atk, $def);
        } # endforeach
    }

}
