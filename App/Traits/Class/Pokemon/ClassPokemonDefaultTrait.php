<?php
trait ClassPokemonDefaultTrait
{
    /**
    * ランク初期値
    * @return void
    */
    public function defaultRank()
    {
        $this->rank = [
            'Attack' => 0,
            'Defense' => 0,
            'SpAtk' => 0,
            'SpDef' => 0,
            'Speed' => 0,
            'Critical' => 0,    # 急所率
            'Accuracy' => 0,    # 命中率
            'Evasion' => 0,     # 回避率
        ];
    }

    /**
    * 個体値初期値
    * @return void
    */
    protected function defaultIv()
    {
        $this->iv = [
            'HP' => null,
            'Attack' => null,
            'Defense' => null,
            'SpAtk' => null,
            'SpDef' => null,
            'Speed' => null,
        ];
    }

    /**
    * 努力値初期値
    * @return void
    */
    protected function defaultEv()
    {
        $this->ev = [
            'HP' => 0,
            'Attack' => 0,
            'Defense' => 0,
            'SpAtk' => 0,
            'SpDef' => 0,
            'Speed' => 0,
        ];
    }

}
