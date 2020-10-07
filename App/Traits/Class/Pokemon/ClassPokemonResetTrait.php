<?php
trait ClassPokemonResetTrait
{
    /**
    * このターン受けたダメージ量をリセットする
    * @return void
    */
    public function resetTurnDamage()
    {
        $this->turn_damage = [
            'physical' => 0,
            'special' => 0,
        ];
    }

}
