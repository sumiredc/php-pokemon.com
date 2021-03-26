<?php
/**
* ポケモンクラス 計算関係のトレイト
*/
trait ClassPokemonCalculationTrait
{

    /**
    * 残りHPの計算
    * @param operator:string::init|death|sub|add
    * @param val:integer
    * @return integer
    */
    public function calRemainingHp(string $operator='init', int $val=0): int
    {
        switch ($operator) {
            // リセット処理
            case 'init':
            // 最大HPをセット
            $this->remaining_hp = $this->getStats('H');
            break;
            // 即死処理
            case 'death':
            $this->remaining_hp = 0;
            break;
            // 減算処理
            case 'sub':
            $this->remaining_hp -= $val;
            break;
            // 加算処理
            case 'add':
            $this->remaining_hp += $val;
            // 最大HPの超過を防止
            if($this->remaining_hp > $this->getStats('H')){
                $this->remaining_hp = $this->getStats('H');
            }
            break;
        }
        // 復活処理（ひんしからの回復）
        if(
            isset($this->sa['SaFainting']) &&
            $this->remaining_hp > 0
        ){
            unset($this->sa['SaFainting']);
        }
        // HPが0以下になった場合の処理
        if($this->remaining_hp <= 0){
            // 状態異常をひんしに書き換え
            $result = $this->setSa('SaFainting');
            $this->remaining_hp = 0;
            // ひんしメッセージとレスポンスを格納
            $msg_id = response()->issueMsgId();
            response()->setMessage($result['message'], $msg_id);
            response()->setResponse([
                'action' => 'fainting',
                'target' => $this->position,
            ], $msg_id);
        }
        // 残りHPを返却
        return $this->remaining_hp;
    }

    /**
    * 指定された技の残りPPの計算処理
    * @param order:integer
    * @param operator:string::init|sub|add
    * @param val:integer
    * @return void
    */
    public function calRemainingPp(int $order, string $operator='init', int $val=0): void
    {
        switch ($operator) {
            // =====================
            // 初期化(全回復)
            // =====================
            case 'init':
            // 指定された技PPを全回復
            $this->move[$order]['remaining'] = $this->move[$order]::getPp($this->move[$order]['correction']);
            break;
            // =====================
            // 減算
            // =====================
            case 'sub':
            $this->move[$order]['remaining'] -= $val;
            if($this->move[$order]['remaining'] < 0){
                // 最小値の処理
                $this->move[$order]['remaining'] = 0;
            }
            break;
            // =====================
            // 加算
            // =====================
            case 'add':
            $class = $this->move[$order]['class'];
            $correction = $this->move[$order]['correction'];
            // 加算
            $this->move[$order]['remaining'] += $val;
            // 最大値の確認
            if($this->move[$order]['remaining'] > $class::getPp($correction)){
                // 最大値の
                $this->move[$order]['remaining'] = $class::getPp($correction);
            }
            break;
        }
    }

    /**
    * 全残りPPの計算処理
    * @param param:string::init|sub|add
    * @param val:integer
    * @return integer
    */
    public function calRemainingPpAll(string $operator='init', int $val=0): void
    {
        switch ($operator) {
            // =====================
            // 初期化(全回復)
            // =====================
            case 'init':
            $this->move = array_map(function($move){
                $move['remaining'] = $move['class']::getPp($move['correction']);
                return $move;
            }, $this->move);
            break;
            // =====================
            // 減算
            // =====================
            case 'sub':
            $this->move = array_map(function($move) use($val){
                // 0以下でなければ減算
                if($move['remaining'] <= 0) {
                    $move['remaining'] -= $val;
                }
                return $move;
            }, $this->move);
            break;
            // =====================
            // 加算
            // =====================
            case 'add':
            $this->move = array_map(function($move) use($val){
                // 加算
                $move['remaining'] += $val;
                // 最大値の確認
                if($move['remaining'] > $move['class']::getPp($move['correction'])) {
                    $move['remaining'] = $move['class']::getPp($move['correction']);
                }
                return $move;
            }, $this->move);
            break;
        }
    }

}
