<?php
/**==================================================================
* へんしん状態
==================================================================**/
trait ClassBattleStateTransformTrait
{

    // /**
    // * へんしん状態の初期値
    // * @return void
    // */
    // public function initTransforms() :void
    // {
    //     $this->transforms = [
    //         'friend' => null,
    //         'enemy' => null,
    //     ];
    // }
    //
    // /**
    // * へんしん状態の初期化(対象指定)
    // * @param position:string::friend|enemy
    // * @return void
    // */
    // protected function resetTransform(string $position): void
    // {
    //     $this->transforms[$position] = null;
    // }
    //
    // /**
    // * へんしん状態の格納
    // * @param pokemon:object::Pokemon
    // * @param enemy:object::Pokemon
    // * @return object::Pokemon
    // */
    // public function setTransform(object $pokemon, object $enemy): object
    // {
    //     $class = get_class($enemy);
    //     $this->transforms[$pokemon->getPosition()] = new $class($pokemon, $enemy);
    //     // へんしん後のポケモンインスタンスを返却
    //     return $this->transforms[$pokemon->getPosition()];
    // }
    //
    // /**
    // * へんしん状態の取得
    // * @param position:string::friend|enemy
    // * @return mixed
    // */
    // public function getTransform(string $position)
    // {
    //     return $this->transforms[$position];
    // }

}
