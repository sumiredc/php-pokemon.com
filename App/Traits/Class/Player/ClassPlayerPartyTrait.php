<?php
/**==================================================================
* パーティー
==================================================================**/
trait ClassPlayerPartyTrait
{

    /**
    * パーティーの取得
    * @return array
    */
    public function getParty(): array
    {
        return $this->party;
    }

    /**
    * パーティーへ追加
    * @param pokemon:object::Pokemon
    * @return boolean
    */
    public function setParty(object $pokemon): bool
    {
        // 立場をチェック
        if($pokemon->getPosition() !== 'friend'){
            return false;
        }
        // 所有数をチェック
        if(count($this->party) <= 6){
            $this->party[] = $pokemon;
            return true;
        }else{
            return false;
        }
    }

    /**
    * パーティーの並び替え
    * @param orders:array
    * @return boolean
    */
    public function sortParty($orders): bool
    {
        // 並び順と現在のポケモン番号を比較
        if(
            array_diff(array_keys($this->party), $orders) ||   # 差分チェック
            count($this->party) !== count($orders)              # 数チェック
        ){
            return false;
        }
        // 並び替え後のパーティーを生成
        $this->party = array_map(function($order){
            return $this->party[$order];
        }, $orders);
        // 結果を返却
        return true;
    }

    /**
    * パーティーから指定したポケモンを取得
    * @param param:mixed
    * @param judge:string::order|id
    * @return object::Pokemon|null
    */
    public function getPartner($param, $judge='order')
    {
        if($judge === 'id'){
            // IDによる検索
            $pokemon = array_filter($this->party, function($pokemon) use($param){
                return $pokemon->getId() === $param;
            });
            return $pokemon[0] ?? null;
        }else{
            // オーダー番号による検索
            return $this->party[$param] ?? null;
        }
    }

    /**
    * パーティー内のポケモンを進化ポケモンに置き換え
    * @param order:integer
    * @param evolve:Pokemon
    * @return void
    */
    public function evolvePartner($order, $evolve): void
    {
        // 進化が可能かを入念にチェック
        if(
            isset($this->party[$order]) &&
            $this->party[$order]->getEvolveFlg() &&
            ($this->party[$order]->getAfterClass() === get_class($evolve))
        ){
            $this->party[$order] = $evolve;
        }
    }

}
