<?php
$root_path = __DIR__.'/../../..';
// 親クラス
require_once($root_path.'/App/Services/Service.php');

/**
 * バトル開始
 */
class StartService extends Service
{

    // /**
    // * @var object Pokemon
    // */
    // protected $enemy;

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
        // プレイヤーレベルを取得
        $player_level = $this->getPlayerLevel();
        // 敵ポケモンのレベルを取得
        $level = $this->getEnemyLevel($player_level);
        // 敵ポケモンを生成
        $this->callEnemy($level);
        // ローカルのみの分岐
        if(@$_SERVER['SERVER_NAME'] === 'php-pokemon.com.local'){
            // battle_state()->setEnemy(
            //     $this->enemy = new Fushigibana(5);
            // );
        }
        // 前ターン状態を格納
        battle_state()->setBefore();
        // 返却値をセット
        setMessage('あ！野生の'.enemy()->getName().'が飛び出してきた！');
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
    * プレイヤーレベル（手持ちポケモンの最大レベル）を取得
    * @return integer
    */
    private function getPlayerLevel(): int
    {
        // パーティーポケモンのレベルだけを取得
        $levels = array_map(function($pokemon){
            return $pokemon->getLevel();
        }, player()->getParty());
        // 最大値を返却
        return max($levels);
    }

    /**
    * 敵ポケモンのレベルを取得
    * @param player_level:integer
    * @return integer
    */
    private function getEnemyLevel(int $player_level): int
    {
        // 最小値(プレイヤーレベル - 3)
        $min = $player_level - 3;
        if($min < 1){
            $min = 1;
        }
        // レベルをランダムで取得
        return random_int($min, $player_level);
    }

    /**
    * 敵ポケモン情報を取得
    * @param level:integer
    * @return void
    */
    private function callEnemy(int $level): void
    {
        // ポケモンのレベルに合わせて野生のポケモンリストを作成
        $pokemon_list = config('wild.early');
        // レベル18以上
        if($level >= 18){
            $pokemon_list = array_merge(
                $pokemon_list, config('wild.middle')
            );
        }
        // レベル40以上
        if($level >= 40){
            $pokemon_list = array_merge(
                $pokemon_list, config('wild.late')
            );
        }
        // レベル80以上
        if($level >= 80){
            $pokemon_list = array_merge(
                $pokemon_list, config('wild.last')
            );
        }
        // ポケモンリストからランダムに取得
        $key = array_rand($pokemon_list);
        // 敵ポケモンをインスタンス化して格納
        battle_state()->setEnemy(
            new $pokemon_list[$key]($level)
        );
    }

}
