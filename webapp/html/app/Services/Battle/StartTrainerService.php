<?php
// 親クラス
require_once app_path('Services/Service.php');
// クラス
require_once app_path('Classes/Trainer.php');

/**
* バトル開始（トレーナー戦）
*/
class StartTrainerService extends Service
{
	/**
	* @var string
	*/
	public static $mode = 'trainer';

	/**
	* @return void
	*/
	public function __construct()
	{
		// バトル状態の初期化
		initBattleState(static::$mode);
	}

	/**
	* @return void
	*/
	public function execute()
	{
		// 味方の選出
		$this->electionFriend();
		// トレーナーの情報の作成とポケモンの選出
		$this->createTrainer();
		// トレーナーとの戦闘記録をカウント
		player()->setTrainer(trainer());
		// ポケモン図鑑への登録確認（発見）
		$this->checkPokedex();
		// 前ターン状態を格納
		battle_state()->setBefore();
		// 返却値をセット
		response()->setMessage(
			trainer()->getPrefixName().'が勝負を仕掛けてきた'
		);
		$msg_id1 = response()->issueMsgId();
		response()->setMessage(
			trainer()->getPrefixName().'は、'.enemy('NAME').'を繰り出してきた',
			$msg_id1
		);
		response()->setResponse([
			'action' => 'start',
			'target' => 'enemy'
		], $msg_id1);
		$msg_id2 = response()->issueMsgId();
		response()->setMessage('ゆけっ！'.friend()->getNickName().'！', $msg_id2);
		response()->setResponse([
			'action' => 'start',
			'target' => 'friend'
		], $msg_id2);
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
	* トレーナー情報の作成
	* @return void
	*/
	private function createTrainer(): void
	{
		switch (static::$mode) {
			// ジムリーダー
			case 'leader':
			$gym = config('gym.'.request('gym'));
			$data = include storage_path('database/leaders/'.$gym::LEADER.'.php');
			$category = 'leader';
			break;
			// 通常トレーナー
			default:
			// 選択されたトレーナーレベルからランダム取得
			$list = glob(storage_path('database/trainers/'.request('trainer').'/*.php'));
			$key = array_rand($list);
			$data = include $list[$key];
			$category = request('trainer');
			break;
		}
		// トレーナーを作成
		battle_state()->setTrainer(
			new Trainer($data, $category)
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
