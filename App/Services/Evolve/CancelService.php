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
    * @var array
    */
    private $party;

    /**
    * @var integer
    */
    private $order;

    /**
    * @return void
    */
    public function __construct($party, $order)
    {
        $this->party = $party;
        $this->order = $order;
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 進化フラグを折る
        $this->party[$this->order]
        ->setEvolveFlgFalse();
    }

}
