<?php
// ボール使用時のトレイト
trait ServiceItemCaptureTrait
{

    /**
    * 揺れ回数
    * @var integer
    */
    protected $shake = 0;

    /**
    * 捕獲判定
    * @param ball:string
    * @return boolean
    */
    protected function useItemCapture(string $ball): bool
    {
        // 捕獲判定
        $result = $this->capture($ball);
        // レスポンス
        response()->setResponse([
            'action' => 'capture',
            'param' => json_encode([
                'shake' => $this->shake,
                'src' => '/Assets/img/item/class/'.$ball.'.png'
            ])
        ], $this->use_msg_id);
        // 判定
        if($result){
            // 捕獲成功
            response()->setResponse(true, 'result');
            response()->setMessage('やったー！'.enemy()->getName().'を捕まえた！');
            // 捕まえたポケモンを登録
            $this->storePokemon();
        }else{
            // 捕獲失敗
            response()->setResponse(false, 'result');
            // 揺れ回数に合わせてメッセージ分岐
            $msg = '残念、ポケモンがボールから出てしまった';
            if($this->shake === 2){
                $msg = 'ああ、捕まえたと思ったのに';
            }
            if($this->shake === 3){
                $msg = '惜しい、あとちょっとのところだったのに';
            }
            response()->setMessage($msg);
        }
        // 結果を返却
        return $result;
    }

    /**
    * 捕獲判定
    * @param ball:string
    * @return boolean
    */
    protected function capture(string $ball): bool
    {
        if($ball === 'ItemMasterBall'){
            // マスターボール専用処理
            $this->shake = 4;
            return true;
        }
        // 1揺れ辺りの成功率（G）を算出
        $g = $this->calProbability($ball);
        // 4揺れ判定(0の可能性もある)
        // 0000〜FFFFの乱数を取る
        while (random_int(0, 65535) <= $g) {
            $this->shake++;
            // 揺れが4以上になれば捕獲成功
            if($this->shake >= 4){
                $capture = true;
                break;
            }
        }
        // 結果を返却
        return $capture ?? false;
    }

    /**
    * 1揺れ辺りの成功率計算処理（G）
    * 計算式
    * B = (((最大HP×3－現在HP×2)×捕捉率×捕獲補正)÷(最大HP×3))×状態補正
    * G = 65536÷(255÷B)^0.1875
    * ・MH： 最大HP
    * ・RH： 現在HP
    * ・C ： 捕捉率
    * ・P ： 捕獲補正
    * ・S ： 状態補正
    * @param ball:string
    * @return float:G
    */
    protected function calProbability(string $ball): float
    {
        // 最大HP
        $mh = enemy()->getStats('HP');
        // 現在HP
        $rh = enemy()->getRemainingHp();
        // 捕捉率
        $c = enemy()->getCapture();
        // 捕獲補正
        $p = $ball::PERFORMANCE;
        /**
        * 状態補正
        */
        if(enemy()->getSa()){
            $s = enemy()->getSa()::CAPTURE;
        }else{
            $s = 1;
        }
        // (((最大HP × 3 - 現在HP × 2) × 捕捉率 × 捕獲補正) ÷ (最大HP × 3)) × 状態補正
        $b = (((($mh * 3) - ($rh * 2)) * $c * $p) / ($mh * 3)) * $s;
        // Gを返却
        return 65536 / (255 / $b) ** 0.1875;
    }

    /**
    * ポケモンの登録
    * @return void
    */
    protected function storePokemon(): void
    {
        // 図鑑登録※立場変更前に実施
        // (トレイト：ServiceCommonRegistPokedexTrait)
        $this->setModalRegistPokedex(enemy());
        // 立場を変更
        enemy()->setPosition();
        if(count(player()->getParty()) < 6){
            // パーティーに追加
            player()->setParty(enemy());
        }else{
            // ボックスへ転送
            $this->transferPokebox();
        }
        // プレイヤーレベルの更新
        if(enemy()->getLevel() > player()->getLevel()){
            player()->levelUp();
        }
    }

    /**
    * ポケモンをボックスへ転送
    * @return void
    */
    protected function transferPokebox()
    {
        // ボックス起動
        startPokebox();
        // 追加
        $result = pokebox()->addPokemon(enemy());
        if($result){
            // 成功
            response()->setMessage(
                enemy()->getName().'は、ボックス'.pokebox()->getSelectedBoxNumber().'へ転送された'
            );
        }else{
            // 失敗
            response()->setMessage('ポケモンの転送に失敗しました');
        }
        // ボックス終了
        shutdownPokebox();
    }

}
