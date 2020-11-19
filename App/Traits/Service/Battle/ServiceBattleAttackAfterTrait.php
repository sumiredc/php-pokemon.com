<?php
// 攻撃処理後の処理
trait ServiceBattleAttackAfterTrait
{
    /**
    * 行動後のチェック処理
    *
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
            if(battle_state()->isFainting($atk_position)){
                // ひんし状態になった
                continue;
            }
            // 状態異常チェック
            $this->checkAfterSa($atk);
            // // ひんし状況の格納
            // $this->fainting[$atk->getPosition()] = $this->checkFainting($atk);
            // ひんしチェック
            if(battle_state()->isFainting($atk_position)){
                // どちらかがひんし状態になった
                continue;
            }
            // 状態変化チェック
            $this->checkAfterSc($atk, $def);
            // // ひんし状況の格納
            // $this->fainting = [
            //     $atk->getPosition() => $this->checkFainting($atk),
            //     $def->getPosition() => $this->checkFainting($def),
            // ];
        } # endforeach
    }

}
