<?php
/**==================================================================
* プレイヤー集計情報用トレイト
==================================================================**/
trait ClassPlayerCounterTrait
{

    /**
    * カウンター
    * @var array
    */
    protected $counter = [
        // トレーナー戦
        'trainer' => [
            'win' => 0, 'lose' => 0,
        ],
        // 野生戦
        'wild' => [
            'win' => 0, 'lose' => 0, 'run' => 0,
        ],
    ];

    /**
    * カウント情報の取得
    * @return array
    */
    public function getCounter(): array
    {
        return $this->counter ?? [];
    }

    /**
    * トレーナー戦のカウント
    * @param judge:string::win|lose
    * @return void
    */
    public function countTrainer(string $judge): void
    {
        // 勝負結果に合わせた判定をセット
        if(in_array($judge, ['win', 'lose'], true)){
            // 値が存在していない場合は初期値をセット
            if(!isset($this->counter['trainer'][$judge])){
                $this->counter['trainer'][$judge] = 0;
            }
            $this->counter['trainer'][$judge]++;
        }
    }

    /**
    * 野生ポケモン戦のカウント
    * @param judge:string::win|lose|run
    * @return void
    */
    public function countWild(string $judge): void
    {
        // 勝負結果に合わせた判定をセット
        if(in_array($judge, ['win', 'lose', 'run'], true)){
            // 値が存在していない場合は初期値をセット
            if(!isset($this->counter['wild'][$judge])){
                $this->counter['wild'][$judge] = 0;
            }
            $this->counter['wild'][$judge]++;
        }
    }

}
