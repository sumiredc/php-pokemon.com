<?php
/**
* ポケモンクラス 計算関係のトレイト
*/
trait ClassPokemonCalculationTrait
{
    /**
    * ランクの加算
    * @param param:string
    * @param val:integer::min:1|max:12
    * @return string
    */
    public function addRank(string $param, int $val): string
    {
        // 変化ランクに合わせたメッセージ
        $msg = [
            1 => '上がった',
            2 => 'ぐーんと上がった',
            3 => 'ぐぐーんと上がった',
            12 => '最大まで上がった',
        ];
        // 既にランクが最大であればfalseを返却
        if($this->rank[$param] === 6){
            return $this->getPrefixName().'の'.transJp($param, 'stats').'はもう上がらない';
        }
        // 加算処理
        $this->rank[$param] += $val;
        // 最大値は6
        if($this->rank[$param] > 6){
            $this->rank[$param] = 6;
        }
        return $this->getPrefixName().'の'.transJp($param, 'stats').'が'.($msg[$val] ?? $msg[3]);
    }

    /**
    * ランクの減算
    * @param param:string
    * @param val:integer::min:1|max:3
    * @return string
    */
    public function subRank(string $param, int $val): string
    {
        // 変化ランクに合わせたメッセージ
        $msg = [
            1 => '下がった',
            2 => 'がくっと下がった',
            3 => 'がくーんと下がった',
        ];
        // 既にランクが最低であればfalseを返却
        if($this->rank[$param] === -6){
            return $this->getPrefixName().'の'.transJp($param, 'stats').'はもう下がらない';
        }
        // 減算処理
        $this->rank[$param] -= $val;
        // 最低値は-6
        if($this->rank[$param] < -6){
            $this->rank[$param] = -6;
        }
        return $this->getPrefixName().'の'.transJp($param, 'stats').'が'.$msg[$val] ?? $msg[3];
    }

    /**
    * 残りHPの計算
    * @param param:string::reset|death|sub|add
    * @param val:integer
    * @return integer
    */
    public function calRemainingHp($param, int $val=0): int
    {
        switch ($param) {
            // リセット処理
            case 'reset':
            // 最大HPをセット
            $this->remaining_hp = $this->getStats('HP');
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
            // 最大HPを超えないようにする
            if($this->remaining_hp > $this->getStats('HP')){
                $this->remaining_hp = $this->getStats('HP');
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
    * 残りPPの計算
    * @param param:string::reset|sub|add
    * @param val:integer
    * @param num:integer
    * @return integer
    */
    public function calRemainingPp(string $param, int $val=0, $num=null): void
    {
        switch ($param) {
            // リセット処理
            case 'reset':
            if(is_null($num)){
                // すべてのPPを全回復
                foreach($this->getMove() as $key => $move){
                    $this->move[$key]['remaining'] = $move['class']->getPp($move['correction']);
                }
            }else{
                // 指定された技PPを全回復
                $this->move[$num]['remaining'] = $this->move[$num]
                ->getPp($this->move[$num]['correction']);
            }
            break;
            // 減算処理
            case 'sub':
            if(is_null($num)){
                // すべてのPPに減算処理
                foreach($this->move as $key => $move){
                    $this->move[$key]['remaining'] -= $val;
                    if($this->move[$key]['remaining'] < 0){
                        // 最小値の処理
                        $this->move[$key]['remaining'] = 0;
                    }
                }
            }else{
                // 指定された技PPに減算処理
                $this->move[$num]['remaining'] -= $val;
                if($this->move[$num]['remaining'] < 0){
                    // 最小値の処理
                    $this->move[$num]['remaining'] = 0;
                }
            }
            break;
            // 加算処理
            case 'add':
            if(is_null($num)){
                // すべてのPPに加算処理
                foreach($this->getMove() as $key => $move){
                    $this->move[$key]['remaining'] += $val;
                    if($this->move[$key]['remaining'] > $move['class']->getPp($move['correction'])){
                        // 最大値の処理
                        $this->move[$key]['remaining'] = $move['class']->getPp($move['correction']);
                    }
                }
            }else{
                // 技をインスタンス化
                $move = new $this->move[$num];
                $this->move[$num]['remaining'] += $val;
                if($this->move[$num]['remaining'] > $move->getPp($this->move[$num]['correction'])){
                    // 最大値の処理
                    $this->move[$num]['remaining'] = $move->getPp($this->move[$num]['correction']);
                }
            }
            break;
        }
    }

}
