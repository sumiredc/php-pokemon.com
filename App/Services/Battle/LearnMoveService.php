<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCheckTrait.php');

/**
* 技の習得処理
*/
class LearnMoveService extends Service
{

    use ServiceBattleCheckTrait;

    /**
    * @var Pokemon:object
    */
    protected $pokemon;

    /**
    * @var Pokemon:object
    */
    protected $tmp_pokemon;

    /**
    * @var array
    */
    protected $before_responses;

    /**
    * @var array
    */
    protected $request;

    /**
    * @param Pokemon:object
    * @param before_response:array
    * @param before_messages:array
    * @param before_modals:array
    * @param request:array
    * @return void
    */
    public function __construct($pokemon, $before_responses, $before_messages, $before_modals, $request)
    {
        $this->pokemon = $pokemon;
        $this->before_responses = $this->unserializeObject($before_responses);
        $this->before_messages = $before_messages;
        $this->before_modals = $this->unserializeObject($before_modals);
        $this->request = $request;
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 描画用ポケモンオブジェクトの作成
        $this->tmp_pokemon = $this->createTmpPokemon();
        // 技の置き換え
        $this->replaceMove();
        // レスポンスの引き継ぎ
        setResponse(
            $this->getUntreatedResponses($this->before_responses, $this->request['id'])
        );
        // メッセージの引き継ぎ
        setMessage(
            $this->getUntreatedResponses($this->before_messages, $this->request['id'], 'message')
        );
        // モーダルの引き継ぎ
        setModal(
            $this->getUntreatedResponses($this->before_modals, $this->request['id'], 'modal'), true
        );
    }

    /**
    * @return Pokomon:object
    */
    public function getTmpPokemon()
    {
        return $this->tmp_pokemon;
    }

    /**
    * 表示用のポケモンオブジェクトを生成
    * @return Pokemon:object
    */
    private function createTmpPokemon()
    {
        $pokemon = clone $this->pokemon;
        // クローンオブジェクトにレベルと残HPをセット
        $pokemon->setLevel($this->request['level']);
        $pokemon->setRemainingHp($this->request['hp']);
        $pokemon->setDefaultExp();
        return $pokemon;
    }

    /**
    * 技の置き換え
    * @return void
    */
    private function replaceMove()
    {
        // 忘れる技を取得
        $forget_move = $this->pokemon
        ->getMove($this->request['forget']);
        // 覚えさせる技を取得
        $new_move = new $this->before_responses[$this->request['id']]['move'];
        // 技を覚えさせる
        $this->pokemon
        ->setMove($new_move, $this->request['forget']);
        // メッセージの返却
        setMessage('1 2の ……ポカン！');
        setMessage($this->pokemon->getNickname().'は、'.$forget_move->getName().'の使い方をキレイに忘れた！そして......');
        setMessage($this->pokemon->getNickname().'は新しく、'.$new_move->getName().'を覚えた！');
    }

    /**
    * 未処理レスポンス・メッセージ・モーダルの引き継ぎ処理
    * @param response:array
    * @param msg_id:string
    * @param param:string::response|message|modal
    * @return array
    */
    private function getUntreatedResponses(array $responses, string $msg_id, string $param='response')
    {
        $cnt = 1;
        switch ($param) {
            /********
            * メッセージの引き継ぎ
            */
            case 'message':
            $key = array_search(
                $msg_id,
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
                $msg_id,
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
                $msg_id,
                array_keys($responses),
                true
            );
            break;
        }
        // 未処理だけを切り出して返却
        return array_splice($responses, $key + $cnt);
    }

}
