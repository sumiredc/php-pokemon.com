<?php
/**==================================================================
* ターンダメージ
==================================================================**/
trait ClassBattleStateTurnDamageTrait
{

    /**
    * ターンダメージの初期値
    * @return void
    */
    protected function dafaultTurnDamages() :void
    {
        $this->turn_damages = [
            'friend' => [
                'physical' => 0,
                'special' => 0,
            ],
            'enemy' => [
                'physical' => 0,
                'special' => 0,
            ],
        ];
    }

    /**
    * ターンダメージの取得
    * @param position:string::friend|enemy
    * @param species:string::physical|special
    * @return integer
    */
    public function getTurnDamage(string $position, string $species) :int
    {
        return $this->turn_damages[$position][$species];
    }

    /**
    * このターン受けたダメージの格納
    * @param position:string::friend|enemy
    * @param species:string::physical|special
    * @param damage:integer
    * @return void
    */
    public function setTurnDamage(string $position, string $species, int $damage) :void
    {
        $this->turn_damages[$position][$species] = $damage;
    }

}
