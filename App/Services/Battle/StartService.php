<?php
// 親クラス
require_once(app_path('Services').'Service.php');

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
        // ポケモン図鑑への登録確認（発見）
        $this->checkPokedex();
        // 前ターン状態を格納
        battle_state()->setBefore();
        // 返却値をセット
        response()->setMessage('あ！野生の'.enemy('NAME').'が飛び出してきた！');
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
        foreach(config('field.'.request('field').'.pokemon') as $pokemon){
            // ポケモンを捕捉率数分抽選箱に投入
            $lottery_box = array_merge(
                $lottery_box,
                array_fill(0, $pokemon::CAPTURE, $pokemon)
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
    }

    /**
    * ポケモン図鑑への登録確認
    * @return void
    */
    private function checkPokedex(): void
    {
        if(
            !player()->pokedex()
            ->isRegisted(enemy('NUMBER'))
        ){
            // 未登録→発見
            player()->pokedex()
            ->discovery(enemy());
        }
    }

}
