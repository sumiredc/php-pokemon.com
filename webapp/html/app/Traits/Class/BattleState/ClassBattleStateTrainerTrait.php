<?php
/**==================================================================
* トレーナー情報
==================================================================**/
trait ClassBattleStateTrainerTrait
{

    /**
    * トレーナー
    * @var array
    */
    private $trainer;

    /**
    * トレーナーが選択中のポケモン番号
    * @var integer
    */
    private $trainer_order = 0;

    /**
    * トレーナー情報の取得
    * @return object
    */
    public function getTrainer(): object
    {
        return $this->trainer;
    }

    /**
    * トレーナー情報の格納
    * @param trainer:object::Trainer
    * @return void
    */
    public function setTrainer(object $trainer): void
    {
        $this->trainer = $trainer;
        // 相手が持つ最初のポケモンを選出して格納
        $this->setEnemy(
            $trainer->getPartner($this->trainer_order)
        );
    }

    /**
    * トレーナーが選択中のポケモン番号
    * @return integer
    */
    public function getTrainerOrder(): int
    {
        return $this->trainer_order;
    }

    /**
    * 次のポケモンへ
    * @return boolean
    */
    public function nextOrder(): bool
    {
        // 戦闘可能なパーティーを取得
        $party = array_filter(trainer()->getParty(), function($pokemon){
            return $pokemon->isFight();
        });
        if(empty($party)){
            // 全滅
            return false;
        }else{
            // 戦闘可能な最初のポケモンを取得
            $next = array_key_first($party);
        }
        // 次のポケモンをセットしてtrueを返却
        $this->setEnemy(
            $this->trainer->getPartner($next)
        );
        $this->trainer_order = $next;
        return true;
    }

}
