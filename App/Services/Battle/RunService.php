<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');
// トレイト
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleAttackTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleCheckTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleEnemyAiTrait.php');
require_once($root_path.'/App/Traits/Service/Battle/ServiceBattleOrderGenelatorTrait.php');

/**
 * にげる
 */
class RunService extends Service
{
    use ServiceBattleAttackTrait;
    use ServiceBattleCheckTrait;
    use ServiceBattleEnemyAiTrait;
    use ServiceBattleOrderGenelatorTrait;

    /**
    * @var object Pokemon
    */
    protected $pokemon;

    /**
    * @var object Pokemon
    */
    protected $enemy;

    /**
    * にげる回数
    * @var integer
    */
    protected $count;

    /**
    * ひんし状態の格納
    * @var array
    */
    protected $fainting = [
        'friend' => false,
        'enemy' => false,
    ];

    /**
    * @return void
    */
    public function __construct($pokemon, $enemy, $count)
    {
        $this->pokemon = $pokemon;
        $this->enemy = $enemy;
        $this->count = $count;
    }

    /**
    * @return void
    */
    public function excute()
    {
        if($this->checkRun()){
            // 逃走成功
            $this->setResponse(true, 'result');
            $this->setMessage('上手く逃げ切れた');
            // バトル終了判定用メッセージの格納
            $this->setMessage(' ', 'battle-end');
            // $this->setResponse(false, 'result');
            // $this->setMessage('逃げられない！');
            // $this->enemyAttack();
        }else{
            // 逃走失敗
            $this->setResponse(false, 'result');
            $this->setMessage('逃げられない！');
            // 相手ポケモンの攻撃
            if(!$this->enemyAttack()){
                // どちらかがひんし状態なら処理終了
                $this->exportProperty('fainting');
                return;
            }
        }
        // 行動後の状態異常・変化をチェック
        $this->afterCheck();
        // 指定したプロパティを返却
        $this->exportProperty('fainting');
    }

    /**
    * にげる判定
    * F = (A × 128 / B) + 30 × C
    * Fを256で割った値 → 逃走成功率
    * @var A 味方ポケモンのすばやさ（ランク補正有り）
    * @var B 相手ポケモンのすばやさ（ランク補正無し）
    * @var C 逃走を試みた回数
    * @return boolean
    */
    private function checkRun()
    {
        // 味方の素早さを取得（ランク補正有り）
        $a = $this->pokemon
        ->getStats('Speed', true);
        // 相手の素早さを取得（ランク補正無し）
        $b = $this->enemy
        ->getStats('Speed');
        // 逃走を試みた回数
        $c = $this->count;
        // 計算式への当てはめ
        $f = ($a * 128 / $b) + 30 * $c;
        // 確率計算
        if(round($f / 256, 2) * 100 >= mt_rand(0, 100)){
            return true;    # 逃走成功
        }else{
            return false;   # 逃走失敗
        }
    }

    /**
    * 相手の攻撃
    *
    * @return void
    */
    private function enemyAttack()
    {
        // AIで技選択
        $ai = $this->aiSelectMove();
        // 敵の技をインスタンス化
        $move = new $ai['class']($ai['remaining'], $ai['correction']);
        // 敵ポケモンの攻撃
        $this->attack($this->enemy, $this->pokemon, $move);
        // ひんし状況の格納
        $this->fainting = [
            'friend' => $this->checkFainting($this->pokemon),
            'enemy' => $this->checkFainting($this->enemy),
        ];
        // ひんしチェック
        if($this->fainting['friend'] || $this->fainting['enemy']){
            return false;
        }
        return true;
    }

    /**
    * 行動後のチェック処理
    *
    * @return void
    */
    private function afterCheck()
    {
        // 素早さで行動順を算出
        $order = $this->orderSpeed(
            [$this->pokemon, $this->enemy],
            [$this->enemy, $this->pokemon],
        );
        // 順番に処理
        foreach($order as list($atk, $def)){
            // ひんしチェック(開始時に行動側がひんし状態になっていないか確認)
            if($this->fainting[$atk->getPosition()]){
                // ひんし状態になった
                continue;
            }
            // 状態異常チェック
            $this->checkAfterSa($atk);
            // ひんし状況の格納
            $this->fainting[$atk->getPosition()] = $this->checkFainting($atk);
            // ひんしチェック
            if($this->fainting[$atk->getPosition()]){
                // ひんし状態になった
                continue;
            }
            // 状態変化チェック
            $this->checkAfterSc($atk, $def);
            // ひんし状況の格納
            $this->fainting = [
                $atk->getPosition() => $this->checkFainting($atk),
                $def->getPosition() => $this->checkFainting($def),
            ];
        } # endforeach
    }

}
