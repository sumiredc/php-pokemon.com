<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * バトル開始
 */
class StartService extends Service
{

    /**
    * @var object Pokemon
    */
    protected $enemy;

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
    public function excute()
    {
        // 敵ポケモンを生成
        $this->enemy = new Fushigidane;
        $this->exportProperty('enemy');
        $this->setMessage('野生の'.$this->enemy->getName().'が現れた！');
    }
}
