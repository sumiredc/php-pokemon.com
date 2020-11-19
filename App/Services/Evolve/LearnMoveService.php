<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
* 技の習得処理
*/
class LearnMoveService extends Service
{

    /**
    * @var Pokemon:object
    */
    protected $pokemon;

    /**
    * @var array
    */
    protected $before_responses;

    /**
    * @param order:integer
    * @param before_response:array
    * @param before_messages:array
    * @param before_modals:array
    * @return void
    */
    public function __construct($order, $before_responses, $before_messages, $before_modals)
    {
        $this->pokemon = player()->getParty()[$order];
        $this->before_responses = unserializeObject($before_responses);
        $this->before_messages = $before_messages;
        $this->before_modals = unserializeObject($before_modals);
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 技の置き換え
        $this->replaceMove();
        // レスポンスの引き継ぎ
        setResponse(
            $this->getUntreatedResponses($this->before_responses)
        );
        // メッセージの引き継ぎ
        setMessage(
            $this->getUntreatedResponses($this->before_messages, 'message')
        );
        // モーダルの引き継ぎ
        setModal(
            $this->getUntreatedResponses($this->before_modals, 'modal'), true
        );
    }

    /**
    * @return Pokomon:object
    */
    public function getPokemon()
    {
        return $this->pokemon;
    }

    /**
    * 技の置き換え
    * @return void
    */
    private function replaceMove()
    {
        // 忘れる技を取得
        $forget_move = $this->pokemon
        ->getMove(request('param.forget'));
        // 覚えさせる技を取得
        $new_move = new $this->before_responses[request('param.id')]['move'];
        // 技を覚えさせる
        $this->pokemon
        ->setMove($new_move, request('param.forget'));
        // メッセージの返却
        setMessage('1 2の ……ポカン！');
        setMessage($this->pokemon->getNickname().'は、'.$forget_move->getName().'の使い方をキレイに忘れた！そして......');
        setMessage($this->pokemon->getNickname().'は新しく、'.$new_move->getName().'を覚えた！');
    }

    /**
    * 未処理レスポンス・メッセージ・モーダルの引き継ぎ処理
    * @param response:array
    * @param param:string::response|message|modal
    * @return array
    */
    private function getUntreatedResponses(array $responses, string $param='response')
    {
        $cnt = 1;
        switch ($param) {
            /********
            * メッセージの引き継ぎ
            */
            case 'message':
            $key = array_search(
                request('param.id'),
                array_column($responses, 1), # メッセージIDの位置は1番目
                true
            );
            // 対象メッセージを含め3つ目までを削除
            $cnt = 3;
            break;
            /********
            * モーダルの引き継ぎ
            */
            case 'modal':
            $key = array_search(
                request('param.id'),
                array_column($responses, 0), # メッセージIDの位置は0番目
                true
            );
            break;
            /********
            * レスポンスの引き継ぎ
            */
            default:
            // メッセージIDのレスポンスが入った位置を取得
            $key = array_search(
                request('param.id'),
                array_keys($responses),
                true
            );
            break;
        }
        // 未処理だけを切り出して返却
        return array_splice($responses, $key + $cnt);
    }

}
