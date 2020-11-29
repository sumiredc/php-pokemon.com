<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * バトル開始
 */
class StartService extends Service
{

    /**
    * @return void
    */
    public function __construct()
    {
        // バトル状態の初期化
        initBattleState();
    }

    /**
    * @return void
    */
    public function execute()
    {
        // 味方の選出
        $this->electionFriend();
        // 敵ポケモンのレベルを取得
        $level = $this->getEnemyLevel();
        // 敵ポケモンを生成
        $this->callEnemy($level);
        // ローカルのみの分岐
        if(@$_SERVER['SERVER_NAME'] === 'php-pokemon.com.local'){
            // battle_state()->setEnemy(
            //     $this->enemy = new Fushigibana(5);
            // );
        }
        // ポケモン図鑑への登録確認（発見）
        $this->checkPokedex();
        // 前ターン状態を格納
        battle_state()->setBefore();
        // 返却値をセット
        response()->setMessage('あ！野生の'.enemy()->getName().'が飛び出してきた！');
        $msg_id = response()->issueMsgId();
        response()->setMessage('ゆけっ！'.friend()->getNickName().'！', $msg_id);
        response()->setResponse([
            'action' => 'start',
            'target' => 'friend'
        ], $msg_id);
    }

    /**
    * 味方を選出する処理
    * @return void
    */
    private function electionFriend(): void
    {
        // 味方ポケモンの選出
        $friend = battle_state()->setFightPokemonOrder();
        battle_state()->setFriend($friend);
    }

    /**
    * 敵ポケモンのレベルを取得
    * @return integer
    */
    private function getEnemyLevel(): int
    {
        // 最小値〜最大値のレベルをランダムで取得
        return random_int(
            config('field.'.request('field').'.min'),
            config('field.'.request('field').'.max')
        );
    }

    /**
    * 敵ポケモン情報を取得
    * @param level:integer
    * @return void
    */
    private function callEnemy(int $level): void
    {
        // 抽選箱の準備
        $lottery_box = [];
        // 保険としてtry-catchを使用
        try {
            foreach(config('field.'.request('field').'.pokemon') as $class){
                // データ取得用のポケモンインスタンスを生成
                $pokemon = new $class(null, null, true);
                $lottery_box = array_merge(
                    $lottery_box,
                    array_fill(0, $pokemon->getCapture(), $class)
                );
            }
            // 0番から配列要素数までの番号をランダムに取得
            $number = random_int(0, count($lottery_box) - 1);
            // シャッフルして配列を添字に置き換え（念の為）
            shuffle($lottery_box);
            // 敵ポケモンをインスタンス化して格納
            battle_state()->setEnemy(
                new $lottery_box[$number]($level)
            );
        } catch (\Exception $ex) {
            // もしポケモンが取得できなかった場合の保険処理
            battle_state()->setEnemy(new Poppo(2));
        }
    }

    /**
    * ポケモン図鑑への登録確認
    * @return void
    */
    private function checkPokedex(): void
    {
        if(
            !player()->pokedex()
            ->isRegisted(enemy()->getNumber())
        ){
            // 未登録→発見
            player()->pokedex()
            ->discovery(enemy());
        }
    }

}
