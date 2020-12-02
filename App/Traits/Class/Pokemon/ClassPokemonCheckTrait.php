<?php
trait ClassPokemonCheckTrait
{

    /**
    * 状態変化の確認用メソッド
    * @param string $key
    * @return void
    */
    public function checkSc($key)
    {
        if(isset($this->sc[$key])){
            return true;
        }else{
            return false;
        }
    }

    /**
    * チャージ技の確認メソッド
    * @param move:string
    * @return void
    */
    public function checkChargeMove($move)
    {
        if(
            isset($this->sc['ScCharge']) &&
            $this->sc['ScCharge']['param'] === $move
        ){
            return true;
        }else{
            return false;
        }
    }

    /**
    * 現在のレベルで覚えられる技があるか確認する処理
    * @return void
    */
    public function checkLevelMove()
    {
        // レベルアップして覚えられる技があれば習得する
        $level_move_keys = array_keys(
            array_column($this->level_move, 0),
            $this->level
        );
        foreach($level_move_keys as $key){
            $move = $this->level_move[$key][1];
            // 覚えようとしている技（クラス）が存在かつ重複していないか
            if(!in_array($move, array_column($this->move, 'class'), true)){
                if(count($this->move) < 4){
                    /**
                    * 技が4つ未満なら即習得
                    */
                    // 技クラスをセット
                    $this->setMove($move);
                    response()->setMessage($move::NAME.'を覚えた！');
                }else{
                    /**
                    * 技選択用モーダルの返却
                    */
                    // メッセージIDを生成
                    $msg_id = response()->issueMsgId();
                    // レベルアップメッセージ
                    response()->setMessage($this->getNickName().'は'.$move::NAME.'を覚えたい');
                    response()->setMessage('しかし技を４つ覚えるので精一杯だ');
                    response()->setMessage($move::NAME.'の代わりに他の技を忘れさせますか？', $msg_id);
                    // レスポンスデータをセット
                    response()->setResponse([
                        'toggle' => 'modal',
                        'target' => '#'.$msg_id.'-modal',
                        'move' => $move,
                        'pokemon_id' => $this->id
                    ], $msg_id);
                    // モーダル用のレスポンスをセット
                    response()->setModal([
                        'id' => $msg_id,
                        'modal' => 'acquire-move',
                        'new_move' => $move,
                        'pokemon_id' => $this->id
                    ]);
                    // 諦めメッセージを事前に用意しておく
                    response()->setMessage($this->getNickName().'は'.$move::NAME.'を覚えるのを諦めた');
                }
            }
        }
    }

    /**
    * 使用できる技があるかどうか調べる処理
    * @return boolean
    */
    public function checkUsedMove(): bool
    {
        $move = array_filter($this->move, function($move){
            // 残PPが残っているものだけを抽出
            return !empty($move['remaining']);
        });
        if(empty($move)){
            return false;
        }else{
            return true;
        }
    }

    /**
    * 戦闘可能状態の確認
    * @return boolean
    */
    public function isFight()
    {
        if($this->remaining_hp <= 0){
            return false;
        }else{
            return true;
        }
    }
}
