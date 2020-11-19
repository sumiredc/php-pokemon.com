<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * 進化キャンセル用サービス
 */
class CancelService extends Service
{

    /**
    * @var integer
    */
    private $order;

    /**
    * @param order:integer
    * @return void
    */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 進化フラグを折る
        player()->getParty()[$this->order]
        ->setEvolveFlgFalse();
    }

}
