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
    * @param ball:object::Item
    * @return boolean
    */
    protected function useItemCapture(object $ball): bool
    {
        // 捕獲判定
        $result = $this->capture($ball);
        if($result){
            // 捕獲成功
            setResponse(true, 'result');
            setMessage('やったー！'.enemy()->getName().'を捕まえた！');
            // 捕まえたポケモンを登録
            $this->storePokemon();
        }else{
            // 捕獲失敗
            setResponse(false, 'result');
            // 揺れ回数に合わせてメッセージ分岐
            $msg = '残念、ポケモンがボールから出てしまった';
            if($this->shake === 2){
                $msg = 'ああ、捕まえたと思ったのに';
            }
            if($this->shake === 3){
                $msg = '惜しい、あとちょっとのところだったのに';
            }
            setMessage($msg);
        }
        // 結果を返却
        return $result;
    }

    /**
    * 捕獲判定
    * @param ball:object::Item
    * @return boolean
    */
    protected function capture(object $ball): bool
    {
        // ボールを消費
        player()->subItem(request('order'));
        // 1揺れ辺りの成功率（G）を算出
        $g = $this->calProbability($ball);
        // 4揺れ判定(0の可能性もある)
        while (random_int(1, 65535) <= $g) {
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
    * 1揺れ辺りの成功率計算処理（B）
    * 計算式
    * B = (((最大HP×3－現在HP×2)×捕捉率×捕獲補正)÷(最大HP×3))×状態補正
    * G = 65536÷(255÷B)^0.1875
    * ・MH： 最大HP
    * ・RH： 現在HP
    * ・C ： 捕捉率
    * ・P ： 捕獲補正
    * ・S ： 状態補正
    * @param ball:object::Item
    * @return float:G
    */
    protected function calProbability(object $ball): float
    {
        // 最大HP
        $mh = enemy()->getStats('HP');
        // 現在HP
        $rh = enemy()->getRemainingHp();
        // 捕捉率
        $c = enemy()->getCapture();
        // 捕獲補正
        $p = $ball->getPerformance();
        /**
        * 状態補正
        * どく（もうどく）orまひorやけど：1.5
        * こおりorねむり：2.5
        */
        $sa = enemy()->getSa();
        if(in_array($sa, ['SaSleep', 'SaFreeze'], true)){
            // こおり or ねむり
            $s = 2.5;
        }else if($sa){
            // どく（もうどく） or まひ or やけど
            $s = 1.5;
        }else{
            // 未状態異常
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
        // 立場を変更
        enemy()->setPosition();
        // パーティーセット
        player()->setParty(enemy());
    }

}
