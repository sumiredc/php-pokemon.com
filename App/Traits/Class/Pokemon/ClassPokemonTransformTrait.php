<?php
// へんしん処理専用トレイト
trait ClassPokemonTransformTrait
{

    /**
    * へんしんによるインスタンスの作成処理
    * @param pokemon:object::Pokemon
    * @param enemy:object::Pokemon
    * @return void
    */
    private function transform(object $pokemon, object $enemy)
    {
        // へんしんでコピーするステータス
        $this->rank = $enemy->getRank();                    # ランク
        $this->iv = $enemy->getIv();                        # 個体値
        $this->ev = $enemy->getEv();                        # 努力値
        $this->move = $enemy->getMove(null, 'array');       # 覚えている技
        // へんしんでコピーされないステータス
        $this->level = $pokemon->getLevel();                # レベル
        if(empty($pokemon->getSa())){                       # 状態異常
            $this->sa = [];
        }else{
            $this->sa = $pokemon->getSa();
        }
        $this->sc = $pokemon->getSc();                      # 状態変化
        $this->position = $pokemon->getPosition();          # 立場
        $this->nickname = $pokemon->getNickName();          # ニックネーム
        $this->remaining_hp = $pokemon->getRemainingHp();   # 残りHP
        $this->exp = $pokemon->getExp();                    # 現在の経験値
        /**
        * へんしん時に書き換えする処理
        */
        // へんしんフラグ
        $this->transform_flg = true;
        // HPは元ポケモンのステータスを引き継ぐ
        $this->base_stats['HP'] = $pokemon->getBaseStats()['HP'];
        $this->iv['HP'] = $pokemon->getIv()['HP'];
        $this->ev['HP'] = $pokemon->getEv()['HP'];
        // 技の残りPPを5にする
        $this->move = array_map(function($move){
            $move['remaining'] = 5;
            return $move;
        }, $this->move);
        // 覚える技・進化レベルを空にする（念の為）
        $this->level_move = [];
        if(isset($this->evolve_level)){
            $this->evolve_level = null;
        }
    }

    /**
    * へんしん状態のステータスを元ポケモンに反映させる処理
    * @param trans_pokemon:object::Pokemon
    * @return void
    */
    public function mirroringTransform(object $trans_pokemon)
    {
        if($this->checkSc('ScTransform')){
            $this->sa = $trans_pokemon->getSa('all');                 # 状態異常
            $this->remaining_hp = $trans_pokemon->getRemainingHp();   # 残HP
        }
    }

    /**
    * バトル判定後の状態をへんしん状態のポケモンに反映させる処理
    * @param base_pokemon:object::Pokemon
    * @return void
    */
    public function judgmentTransform(object $base_pokemon)
    {
        $this->ev = $base_pokemon->getEv();         # 努力値
        $this->level = $base_pokemon->getLevel();   # レベル
        $this->exp = $base_pokemon->getExp();       # 経験値
    }
}
