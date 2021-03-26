<?php
/**==================================================================
* トレーナー情報（勝利したトレーナー情報を格納）
==================================================================**/
trait ClassPlayerTrainerTrait
{

    /**
    * トレーナー
    * @var array
    */
    protected $trainers = [];

    /**
    * トレーナーと戦える回数
    * @var integer
    */
    protected $trainer_times = 5;

    /**
    * 対象トレーナーと戦ったかどうかの確認
    * @param category:string
    * @param id:string
    * @return boolean
    */
    public function isTrainer(string $category, string $id): bool
    {
        return in_array($id, $this->trainers[$category], true);
    }

    /**
    * 対象トレーナーと戦えるかの確認
    * @param category:string
    * @return boolean
    */
    public function isFightTrainer(string $category): bool
    {
        return $this->getTrainerCount($category) < $this->trainer_times;
    }

    /**
    * 戦ったトレーナー名一覧を取得
    * @param category:string
    * @return array
    */
    public function getTrainers(string $category): array
    {
        return $this->trainers[$category] ?? [];
    }

    /**
    * 戦った全トレーナー名一覧を取得
    * @param category:string
    * @return array
    */
    public function getTrainersAll(): array
    {
        return $this->trainers ?? [];
    }

    /**
    * 戦ったトレーナー数を取得
    * @param category:string
    * @return integer
    */
    public function getTrainerCount(string $category): int
    {
        return count($this->trainers[$category] ?? []);
    }

    /**
    * 対象トレーナーと戦える残り回数を取得
    * @param category:string
    * @return integer
    */
    public function getRemainingTrainerCount(string $category): int
    {
        return $this->trainer_times - $this->getTrainerCount($category);
    }

    /**
    * 戦ったトレーナー情報の格納
    * @param trainer:object::Trainer
    * @return void
    */
    public function setTrainer(Trainer $trainer): void
    {
        $this->trainers[$trainer->getCategory()][] = $trainer->getId();
    }

}
