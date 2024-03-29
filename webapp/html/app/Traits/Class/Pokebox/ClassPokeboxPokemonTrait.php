<?php
trait ClassPokeboxPokemonTrait
{
    /**
    * ポケモンの追加
    * @param pokemon:object::Pokemon
    * @return boolean
    */
    public function addPokemon(object $pokemon): bool
    {
        // 引数の値を確認(ポケモンクラス、立場の確認)
        if(
            !is_a($pokemon, 'Pokemon') ||
            $pokemon->getPosition() !== 'friend'
        ){
            return false;
        }
        // 選択中のボックスに空きがあるかの確認
        if($this->getAmountUsed($this->selected) < config('pokebox.max')){
            // 空き有り
            $box_number = $this->selected;
        }else{
            // 空きボックスの取得
            $free_box = array_fileter($this->pokebox, function($box){
                return count($box) < config('pokebox.max');
            });
            if(empty($free_box)){
                // ボックスに空きが無ければ新しくボックスを追加
                $box_number = $this->addBox();
            }else{
                // 空きボックスの先頭を取得
                $box_number = array_key_first($free_box);
            }
        }
        // 格納するボックスへ切り替え
        $this->selectBox($box_number);
        // 格納前に全回復させる
        $pokemon->recovery();
        // シリアライズして配列で格納(負荷軽減)
        $this->pokebox[$box_number][] = [
            'class' => get_class($pokemon),
            'name' => $pokemon->getNickname(),
            'level' => $pokemon->getLevel(),
            'object' => serializeObject($pokemon),
            'id' => $pokemon->getId(),
        ];
        // 格納完了
        return true;
    }

    /**
    * ボックス内のポケモン情報を削除する
    * @param id:string
    * @return void
    */
    public function releasePokemon(string $id): void
    {
        // ポケモンIDを使って取得
        $pokemon = array_filter($this->pokebox[$this->selected], function($pokemon) use($id){
            return $pokemon['id'] === $id;
        });
        // ポケモンが見つかれば削除
        if($pokemon){
            unset($this->pokebox[$this->selected][array_key_first($pokemon)]);
            // 採番
            $this->pokebox[$this->selected] = array_values($this->pokebox[$this->selected]);
        }
    }

    /**
    * 指定されたポケモンの手前にいるポケモン情報を取得する
    * @param id:string
    * @return object::Pokemon|null
    */
    public function prevPokemon(string $id)
    {
        // ポケモンIDを使って取得
        $pokemon = array_filter($this->pokebox[$this->selected], function($pokemon) use($id){
            return $pokemon['id'] === $id;
        });
        // 先頭でなければ手前の番号のポケモン情報を返却
        if($order = array_key_first($pokemon)){
            // 復号化して返却
            return unserializeObject(
                $this->pokebox[$this->selected][--$order]['object']
            );
        }else{
            return null;
        }
    }

    /**
    * 指定されたポケモンの手前にいるポケモン情報を取得する
    * @param id:string
    * @return object::Pokemon|null
    */
    public function nextPokemon(string $id)
    {
        // ポケモンIDを使って取得
        $pokemon = array_filter($this->pokebox[$this->selected], function($pokemon) use($id){
            return $pokemon['id'] === $id;
        });
        // 末尾でなければ次の番号のポケモン情報を返却
        $order = array_key_first($pokemon);
        if(
            !is_null($order) &&
            array_key_last($this->pokebox[$this->selected]) !== $order
        ){
            // 復号化して返却
            return unserializeObject(
                $this->pokebox[$this->selected][++$order]['object']
            );
        }else{
            return null;
        }
    }

}
