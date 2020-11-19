<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * 全回復（ポケモンセンター）
 */
class RecoveryService extends Service
{

    // /**
    // * @var object::Player
    // */
    // private $player;

    /**
    * @return void
    */
    public function __construct()
    {
        //
    }

    /**
    * @return void
    */
    public function execute()
    {
        foreach(player()->getParty() as $partner){
            $this->recovery($partner);
        }
        setMessage([
            ['お預かりしたポケモンたちは、皆元気になりましたよ'],
            ['またのご利用お待ちしております']
        ]);
    }

    /**
    * 全回復
    *
    * @return void
    */
    private function recovery($partner)
    {
        // HP回復
        $partner->calRemainingHp('reset');
        // 状態異常解除
        $partner->releaseSa();
        // PP回復
        $partner->calRemainingPp('reset');
    }

}
