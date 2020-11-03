<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * 進化初期画面用サービス
 */
class DefaultService extends Service
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
        // 進化メッセージの生成
        $this->setEvolveMessages();
    }

    /**
    * 進化メッセージの生成処理
    *
    * @return void
    */
    private function setEvolveMessages()
    {
        $pokemon = $this->party[$this->order];
        // 確認メッセージ
        $msg_id1 = issueMsgId();
        setMessage('・・・おや！？ '.$pokemon->getNickName().'の様子が・・・！');
        setAutoMessage($msg_id1);
        setResponse([
            'action' => 'evolve'
        ], $msg_id1);
        // 終了メッセージ
        $msg_id2 = issueMsgId();
        setMessage('あれ・・・？ '.$pokemon->getNickName().'の変化が止まった！', $msg_id2);
        setResponse([
            'action' => 'cancel'
        ], $msg_id2);
        // 空メッセージのセット
        setEmptyMessage();
    }

}
