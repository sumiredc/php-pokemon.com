<?php
trait ClassPokemonActionTrait
{

    /**
    * レベルアップ処理
    * @param msg_id::string|null
    * @return void
    */
    protected function actionLevelUp($msg_id=null): void
    {
        // メッセージIDの指定があれば、経験値バーのアニメーション用レスポンスをセット(戦闘ポケモンのみ)
        if(
            !is_null($msg_id) &&
            battle_state()->getPokemonId() === $this->id
        ){
            response()->setResponse([
                'param' => 100, # %
                'action' => 'expbar',
            ], $msg_id);
        }
        // 現在のHPを取得
        $before_hp = $this->getStats('H');
        // レベルアップ
        $this->level++;
        // HPの上昇値分だけ残りHPを加算(ひんし状態を除く)
        if($this->isFight()){
            $this->calRemainingHp('add', $this->getStats('H') - $before_hp);
        }
        // メッセージIDを生成
        $msg_id1 = response()->issueMsgId();
        $msg_id2 = response()->issueMsgId();
        // レベルアップアニメーション用レスポンス(戦闘ポケモンのみ)
        if(battle_state()->getPokemonId() === $this->id){
            response()->setResponse([
                'param' => json_encode([
                    'level' => $this->level,
                    'remaining_hp' => $this->getRemainingHp(),
                    'remaining_hp_per' => $this->getRemainingHp('per'),
                    'max_hp' => $this->getStats('H'),
                ]),
                'action' => 'levelup',
            ], $msg_id1);
            response()->setAutoMessage($msg_id1);
        }
        // レベルアップメッセージ
        response()->setMessage($this->getNickName().'のレベルは'.$this->level.'になった！', $msg_id2);
        // レスポンスデータをセット
        response()->setResponse([
            'toggle' => 'modal',
            'target' => '#'.$msg_id2.'-modal',
        ], $msg_id2);
        // モーダル用のレスポンスをセット
        response()->setModal([
            'id' => $msg_id2,
            'modal' => 'levelup',
            'stats' => $this->getStatsAll(), # 連続レベルアップ時に書き換わるため現在の値をセット(実数値)
            'pokemon' => $this
        ]);
        // 現在のレベルで習得できる技があるか確認
        $this->isLevelMove();
        // プレイヤーレベルの更新
        if($this->level > player()->getLevel()){
            player()->levelUp();
        }
    }

    /**
    * 技習得処理
    * @param move:string
    * @return boolean
    */
    protected function actionLearnMove(string $move): bool
    {
        // 覚えようとしている技（クラス）が存在かつ重複していないか
        if(in_array($move, array_column($this->move, 'class'), true)){
            response()->setMessage($this->getNickname().'は、既に'.$move::NAME.'を覚えています');
            // 失敗
            return false;
        }
        // 習得処理
        if(count($this->move) < 4){
            /**
            * 技が4つ未満なら即習得
            */
            // 技クラスをセット
            $this->setMove($move);
            response()->setMessage($this->getNickname().'は、新しく'.$move::NAME.'を覚えた！');
        }else{
            /**
            * 技選択用モーダルの返却
            */
            // メッセージIDを生成
            $msg_id = response()->issueMsgId();
            // レベルアップメッセージ
            response()->setMessage($this->getNickname().'は、'.$move::NAME.'を覚えたい');
            response()->setMessage('しかし、技を４つ覚えるので精一杯だ');
            response()->setMessage($move::NAME.'の代わりに、他の技を忘れさせますか？', $msg_id);
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
            response()->setMessage($this->getNickname().'は、'.$move::NAME.'を覚えるのを諦めた');
        }
        // 成功（確認状態も成功とみなす）
        return true;
    }

}
