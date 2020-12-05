<?php
require_once(app_path('Services').'Service.php');

/**
 * 進化初期画面用サービス
 */
class DefaultService extends Service
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
        $pokemon = player()->getParty()[$this->order];
        // 確認メッセージ
        $msg_id1 = response()->issueMsgId();
        response()->setMessage('・・・おや！？ '.$pokemon->getNickName().'の様子が・・・！');
        response()->setAutoMessage($msg_id1);
        response()->setResponse([
            'action' => 'evolve'
        ], $msg_id1);
        // 終了メッセージ
        $msg_id2 = response()->issueMsgId();
        response()->setMessage('あれ・・・？ '.$pokemon->getNickName().'の変化が止まった！', $msg_id2);
        response()->setResponse([
            'action' => 'cancel'
        ], $msg_id2);
        // 空メッセージのセット
        response()->setEmptyMessage();
    }

}
