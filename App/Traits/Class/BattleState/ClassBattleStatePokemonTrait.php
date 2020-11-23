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
    * 現在のポケモン番号を取得
    * @return integer
    */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
    * 開始時に戦闘に参加するポケモン番号を生成
    * @return object::Pokemon
    */
    public function setFightPokemonOrder(): object
    {
        $orders = array_filter(player()->getParty(), function($partner){
            return $partner->getRemainingHp() > 0;
        });
        // プロパティへ格納
        $this->order = array_key_first($orders);
        // 選出されたポケモンを取得
        return player()->getParty()[$this->order];
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
                $this->order = $order;
            }
        }
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
            if(empty($this->$position->getRemainingHp())){
                // 瀕死状態
                $result = true;
            }
        }else{
            // 両方チェック
            if(
                empty($this->enemy->getRemainingHp()) ||
                empty($this->friend->getRemainingHp())
            ){
                // 瀕死有り
                $result = true;
            }
        }
        return $result ?? false;
    }

}
