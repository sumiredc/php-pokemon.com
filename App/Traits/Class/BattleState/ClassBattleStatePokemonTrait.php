<?php
/**==================================================================
* ポケモン関係の処理
==================================================================**/
trait ClassBattleStatePokemonTrait
{

    /**==================================================================
    * 前ターンのポケモン関係処理
    ==================================================================**/

    /**
    * 前ターンのポケモン状態の初期値
    * @return void
    */
    protected function defaultBefore(): void
    {
        $this->before  = [
            'friend' => null,
            'enemy' => null,
        ];
    }

    /**
    * 味方ポケモンを取得
    * @param position:string
    * @param pokemon:null|object::Pokemon
    * @return void
    */
    public function setBefore(string $position='', $pokemon=null): void
    {
        if(in_array($position, config('pokemon.position'), true)){
            // どちらか指定(第２引数でインスタンスの指定可能)
            if(!is_a($pokemon, 'Pokemon')){
                $pokemon = null;
            }
            // へんしんオブジェクトがあればgtTransformの値をクローンして格納
            $this->before[$position] = clone ($pokemon ?? $this->getTransform($position) ?? $this->$position);
        }else{
            // 両方
            $this->before['friend'] = clone ($this->getTransform('friend') ?? $this->friend);
            $this->before['enemy'] =  clone ($this->getTransform('enemy') ?? $this->enemy);
        }
    }

    /**
    * 描画用ポケモンの取得
    * @return object::Pokemon
    */
    public function getBefore($position): object
    {
        return $this->before[$position];
    }

    /**==================================================================
    * 味方ポケモン関係処理
    ==================================================================**/

    /**
    * 現在バトルに参加しているポケモン番号を取得
    * @return integer
    */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
    * 現在バトルに参加しているポケモンIDを取得
    * @return integer
    */
    public function getPokemonId(): string
    {
        return player()->getPartner($this->order)
        ->getId();
    }

    /**
    * 戦闘に参加しているポケモン番号の格納(private)
    * @param order:integer
    * @return void
    */
    private function setOrder(int $order): void
    {
        // 番号をプロパティへ格納
        $this->order = $order;
        // 戦闘に参加したポケモンリストに格納
        if(!in_array($order, $this->fought_orders, true)){
            $this->fought_orders[] = $order;
        }
    }

    /**
    * 開始時に戦闘に参加するポケモン番号を生成
    * @return object::Pokemon
    */
    public function setFightPokemonOrder(): object
    {
        $orders = array_filter(player()->getParty(), function($partner){
            return $partner->isFight();
        });
        // 番号をプロパティへ格納
        $this->setOrder(array_key_first($orders));
        // 選出されたポケモンを取得
        return player()->getPartner($this->order);
    }

    /**
    * 味方ポケモンを取得
    * @return object::Pokemon
    */
    public function getFriend(): object
    {
        return $this->friend;
    }

    /**
    * 味方を格納
    * @param pokemon:object::Pokemon
    * @param order_reset:boolean
    * @return void
    */
    public function setFriend(object $pokemon, bool $order_reset=false): void
    {
        if($pokemon->getPosition() === 'friend'){
            $this->friend = $pokemon;
        }else{
            return;
        }
        // もし第２引数がtrueであればオーダーを再セット
        if($order_reset){
            $order = array_search($pokemon, player()->getParty());
            if($order !== false){
                $this->setOrder($order);
            }
        }
    }

    /**
    * 経験値を貰える権利があるポケモン番号の取得
    * @return array
    */
    public function getEntitledExpOrders(): array
    {
        /**
        * 現在戦闘中のポケモンを先頭にする
        */
        // 現在戦闘中のポケモン番号を削除(次のarray_unshiftが破壊的な関数のため変数へ格納)
        $fought_orders = array_diff($this->fought_orders, [$this->order]);
        // 先頭に現在のポケモン番号を追加
        array_unshift($fought_orders,  $this->order);
        // 戦闘可能状態でフィルターにかけて返却
        return array_filter(
            $fought_orders,
            function($order){
                return player()->getPartner($order)->isFight();
            }
        );
    }

    /**==================================================================
    * 敵ポケモン関係処理
    ==================================================================**/

    /**
    * 敵ポケモンを取得
    * @return object::Pokemon
    */
    public function getEnemy(): object
    {
        return $this->enemy;
    }

    /**
    * 敵を格納
    * @param object::Pokemon
    * @return void
    */
    public function setEnemy(object $pokemon): void
    {
        if($pokemon->getPosition() === 'enemy'){
            $this->enemy = $pokemon;
        }
    }

    /**==================================================================
    * ひんし状態関係処理
    ==================================================================**/

    /**
    * 瀕死状態の確認
    * @param position:string
    * @return boolean
    */
    public function isFainting(string $position=''): bool
    {
        if(in_array($position, config('pokemon.position'), true)){
            // どちらか指定
            return !$this->$position->isFight();
        }else{
            // 両方チェック
            if(
                !$this->enemy->isFight() ||
                !$this->friend->isFight()
            ){
                // 瀕死状態
                return true;
            }else{
                // 瀕死状態ではない
                return false;
            }
        }
    }

}
