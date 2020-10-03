<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * 全回復（ポケモンセンター）
 */
class RecoveryService extends Service
{

    /**
    * @var object Pokemon
    */
    private $pokemon;

    /**
    * @return void
    */
    public function __construct($pokemon)
    {
        $this->pokemon = $pokemon;
    }

    /**
    * @return void
    */
    public function excute()
    {
        $this->recovery();
        $this->setMessage([
            ['お預かりしたポケモンたちは、皆元気になりましたよ'],
            ['またのご利用お待ちしております']
        ]);
    }

    /**
    * 全回復
    *
    * @return void
    */
    private function recovery()
    {
        // HP回復
        $this->pokemon
        ->calRemainingHp('reset');
        // 状態異常解除
        $this->pokemon
        ->releaseSa();
        // PP回復
        $this->pokemon
        ->calRemainingPp('reset');
    }

}
