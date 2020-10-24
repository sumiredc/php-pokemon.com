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
    * @return void
    */
    public function __construct($pokemon, $before_responses, $before_messages, $request)
    {
        $this->pokemon = $pokemon;
        $this->before_responses = $before_responses;
        $this->before_messages = $before_messages;
        $this->request = $request;
    }

    /**
    * @return void
    */
    public function execute()
    {
        $this->tmp_pokemon = $this->createTmpPokemon();
        $this->replaceMove();
        // メッセージとレスポンスの引き継ぎ
        $this->setMessage(
            $this->getUntreatedResponses($this->before_messages, $this->request['id'], true)
        );
        $this->setResponse(
            $this->getUntreatedResponses($this->before_responses, $this->request['id'])
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
        $this->setMessage('1 2の ……ポカン！');
        $this->setMessage($this->pokemon->getNickname().'は、'.$forget_move->getName().'の使い方をキレイに忘れた！そして......');
        $this->setMessage($this->pokemon->getNickname().'は新しく、'.$new_move->getName().'を覚えた！');
    }

    /**
    * 未処理メッセージ・レスポンスの引き継ぎ処理
    * @return void
    */
    private function getUntreatedResponses($responses, $msg_id, $msg=false)
    {
        if($msg){
            /**
            * メッセージの処理
            */
            $key = array_search(
                $msg_id,
                array_column($responses, 1),
                true
            );
            // 対象メッセージを含め3つ目までを削除した配列を返却
            return array_splice($responses, $key + 3);
        }else{
            /**
            * レスポンスの処理
            */
            // メッセージIDのレスポンスが入った位置を取得
            $key = array_search(
                $msg_id,
                array_keys($responses),
                true
            );
            // メッセージIDより後のレスポンスを返却
            return array_splice($responses, $key + 1);
        }
    }

}
