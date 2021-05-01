<?php
require_once app_path('Classes/Pokemon.php');

// チェック関係格納トレイト
trait ServiceBattleCheckTrait
{

	/**
	* 技の使用可否判定
	* @param string $move
	* @param App\Classes\Pokemon $pokemon
	* @return boolean::true::使用可能|false:使用不可(わるあがき)
	*/
	protected function checkEnabledMove(string $move, Pokemon $pokemon)
	{
		if($move === 'MoveStruggle'){
			// わるあがき
			return false;
		}
		// 選択された技番号を取得
		$order = array_search(
			$move,
			array_column($pokemon->getMove(), 'class'),
		);
		// チャージターン && あばれる状態 && がまん状態でなければPP減少
		if(
			!$this->checkChargeTurn($pokemon, $move) &&
			!$pokemon->isSc('ScThrash') &&
			!$pokemon->isSc('ScBide')
		){
			// 残PPをマイナス1
			$pokemon->calRemainingPp($order, 'sub', 1);
		}
		return true;
	}

	/**
	* チャージターンかどうかの確認
	* @param pokemon:object::Pokemon
	* @param move:string
	* @return boolean
	*/
	protected function checkChargeTurn(object $pokemon, string $move): bool
	{
		// チャージ技ではない
		if(!$move::CHARGE_FLG){
			return false;
		}
		// 現在未チャージ状態
		if(!$pokemon->isSc('ScCharge')){
			// チャージターン
			return true;
		}
		// 残チャージターン数が1超過
		if($pokemon->getScTurn('ScCharge') > 1){
			// チャージターン
			return true;
		}
		// チャージターンではない
		return false;
	}

	/**
	* 攻撃前の状態異常判定
	* @param pokemon:object::Pokemon
	* @return boolean
	*/
	protected function checkBeforeSa(object $pokemon): bool
	{
		$sa = $pokemon->getSa();
		if(empty($sa)){
			// 状態異常にかかっていない
			return true;
		}
		// アタック前の症状を発火
		$result = $sa::onsetBefore($pokemon);
		// 解除の有無確認
		if($result['release'] ?? false){
			$msg_id = response()->issueMsgId();
			response()->setResponse([
				'action' => 'sa-release',
				'target' => $pokemon->getPosition()
			], $msg_id);
		}
		// メッセージがあれば格納
		if(isset($result['message'])){
			response()->setMessage($result['message'], $msg_id ?? null);
		}
		// 結果を返却
		return $result['result'];
	}

	/**
	* アタック前の状態変化チェック
	* 1. ひるみ
	* 2. 反動
	* 3. かなしばり
	* 4. こんらん
	* @param App\Classes\Pokemon $pokemon
	* @param string $move
	* @return boolean
	*/
	protected function checkBeforeSc(Pokemon $pokemon, string $move)
	{
		// 状態変化の値を取得
		if(empty($pokemon->getSc())){
			// 状態変化にかかっていない
			return true;
		}
		/**
		* がまん
		*/
		// ターンカウントを進める
		$pokemon->goScTurn('ScBide', false);
		// がまん中
		if($pokemon->getScTurn('ScBide') > 0){
			return false;
		}
		/**
		* ひるみ
		*/
		if($pokemon->isSc('ScFlinch')){
			// 行動失敗（ひるみ解除はcheckAfterScで行う※先手はひるみの影響を受けないため）
			return false;
		}
		/**
		* 反動
		*/
		if($pokemon->isSc('ScRecoil')){
			// 反動メッセージを格納
			response()->setMessage(
				ScRecoil::getFailedMessage($pokemon->getPrefixName())
			);
			// 反動解除
			$pokemon->initSc('ScRecoil');
			return false;
		}
		/**
		* かなしばり
		*/
		if(
			$pokemon->isSc('ScDisable') &&
			$move === $pokemon->getScOther('ScDisable')
		){
			// 行動失敗メッセージを格納
			response()->setMessage(
				ScDisable::getFailedMessage($pokemon->getPrefixName(), $move)
			);
			// あばれる状態で金縛りを受けた場合は、失敗後に解除※こんらん状態にはならない
			if(
				$pokemon->isSc('ScThrash') &&
				$pokemon->getScOther('ScThrash') === $move
			){
				$pokemon->initSc('ScThrash');
			}
			// チャージ状態で金縛りを受けた場合は、失敗後に解除
			if(
				$pokemon->isSc('ScCharge') &&
				$pokemon->getScOther('ScCharge') === $move
			){
				$pokemon->initSc('ScCharge');
			}
			return false;
		}
		/**
		* こんらん
		*/
		if($pokemon->isSc('ScConfusion')){
			// こんらんのターンカウントを進める
			$pokemon->goScTurn('ScConfusion');
			if(!$pokemon->isSc('ScConfusion')){
				// こんらん解除
				response()->setMessage(
					ScConfusion::getRecoveryMessage($pokemon->getPrefixName())
				);
			}else{
				// こんらんしている旨のメッセージ
				response()->setMessage($pokemon->getPrefixName().'は混乱している');
				// 1/3の確率で行動失敗
				if(!random_int(0, 2)){
					// メッセージIDの生成
					$msg_id = response()->issueMsgId();
					// 行動失敗（自分に威力４０の物理ダメージ）
					response()->setMessage(
						ScConfusion::getFailedMessage($pokemon->getPrefixName()),
						$msg_id
					);
					// ダメージ計算
					$damage = $this->calDamage(
						$pokemon->getLevel(),         # レベル
						$pokemon->getStatsM('A'),     # 物理攻撃値（補正値込み）
						$pokemon->getStatsM('B'),     # 物理防御値（補正値込み）
						40, # 技の威力
						1,  # 補正値
					);
					// ダメージ計算
					$pokemon->calRemainingHp('sub', $damage);
					// HPバーのアニメーション用レスポンス
					response()->setResponse([
						'param' => $damage,
						'action' => 'hpbar',
						'target' => $pokemon->getPosition(),
					], $msg_id);
					// 行動失敗
					return false;
				}
			}
		}
		return true;
	}

	/**
	* アタック後の状態異常チェック
	*
	* @param pokemon:object::Pokemon
	* @return void
	*/
	protected function checkAfterSa(object $pokemon)
	{
		if(empty($pokemon->getSa())){
			// 状態異常にかかっていない
			return;
		}
		// メッセージIDの生成
		$msg_id = response()->issueMsgId();
		// 状態異常に合わせた分岐
		switch ($pokemon->getSa()) {
			/**
			* どく
			*/
			case 'SaPoison':
			// 最大HPの1/8ダメージを受ける
			// 小数点以下切り捨て
			$damage = (int)($pokemon->getStats('H') / 8);
			if($damage < 1){
				// 最小ダメージ数は1
				$damage = 1;
			}
			// メッセージ
			response()->setAutoMessage($msg_id); # アニメーション用
			response()->setMessage(
				SaPoison::getTurnMessage($pokemon->getPrefixName())
			);
			break;
			/**
			* もうどく
			*/
			case 'SaBadPoison':
			// 最大HPの(ターン数/16)ダメージを受ける（最大15/16）
			// ターンカウントを進める
			$pokemon->goSaTurn();
			// 小数点以下切り捨て
			$damage = (int)($pokemon->getStats('H') / 16) * $pokemon->getSa('turn');
			if($damage < 1){
				// 最小ダメージ数は1
				$damage = 1;
			}
			// メッセージ
			response()->setAutoMessage($msg_id); # アニメーション用
			response()->setMessage(
				SaBadPoison::getTurnMessage($pokemon->getPrefixName())
			);
			break;
			/**
			* やけど
			*/
			case 'SaBurn':
			// 最大HPの1/16ダメージを受ける
			// 小数点以下切り捨て
			$damage = (int)($pokemon->getStats('H') / 16);
			if($damage < 1){
				// 最小ダメージ数は1
				$damage = 1;
			}
			// メッセージ
			response()->setAutoMessage($msg_id); # アニメーション用
			response()->setMessage(
				SaBurn::getTurnMessage($pokemon->getPrefixName())
			);
			break;
		}
		// ダメージ判定
		if(isset($damage)){
			$pokemon->calRemainingHp('sub', $damage);
			// HPバーのアニメーション用レスポンス
			response()->setResponse([
				'param' => $damage,
				'action' => 'hpbar',
				'target' => $pokemon->getPosition(),
			], $msg_id);
		}
	}

	/**
	* アタック後の状態変化チェック
	*
	* @param pokemon:object::Pokemon
	* @return void
	*/
	protected function checkAfterSc(object $sicked_pokemon, object $enemy_pokemon)
	{
		// ひるみ解除
		$sicked_pokemon->initSc('ScFlinch');
		// 状態変化にかかっていない
		if(empty($sicked_pokemon->getSc())){
			return;
		}
		/**
		* やどりぎのタネ
		*/
		if($sicked_pokemon->isSc('ScLeechSeed')){
			// メッセージIDの生成(ダメージ用と回復用)
			$ls_msg_id1 = response()->issueMsgId();
			$ls_msg_id2 = response()->issueMsgId();
			// 最大HPの1/8HPを吸収する
			// 小数点以下切り捨て
			$damage = (int)($sicked_pokemon->getStats('H') / 8);
			if($damage < 1){
				// 最小ダメージ数は1
				$damage = 1;
			}
			// HPバーのアニメーション用レスポンス
			response()->setResponse([
				'param' => $damage,
				'action' => 'hpbar',
				'target' => $sicked_pokemon->getPosition(),
			], $ls_msg_id1);
			// 回復
			$enemy_pokemon->calRemainingHp('add', $damage);
			// HPバーのアニメーション用レスポンス
			response()->setResponse([
				'param' => $damage * -1, # 加算するため負の数に変換してセット
				'action' => 'hpbar',
				'target' => $enemy_pokemon->getPosition(),
			], $ls_msg_id2);
			// メッセージ（アニメーション用に空メッセージを2つ用意）
			response()->setAutoMessage($ls_msg_id1);
			response()->setAutoMessage($ls_msg_id2);
			response()->setMessage(
				ScLeechSeed::getTurnMessage($sicked_pokemon->getPrefixName())
			);
			// ダメージ計算(アニメーション後に実施)
			$sicked_pokemon->calRemainingHp('sub', $damage);
			// HPが０になっていればチェック終了
			if(!$sicked_pokemon->getRemainingHp()){
				return;
			}
		}
		/**
		* バインド
		*/
		if($sicked_pokemon->isSc('ScBind')){
			// 最大HPの1/8ダメージを受ける
			// バインドのターンカウントを進める
			$class = $sicked_pokemon->getScOther('ScBind'); # 解除すると取得できないため、ターンカウントを進める前に実行
			$sicked_pokemon->goScTurn('ScBind');
			if(!$sicked_pokemon->isSc('ScBind')){
				// バインド解除
				response()->setMessage(
					ScBind::getRecoveryMessage($sicked_pokemon->getPrefixName(), $class)
				);
			}else{
				// メッセージIDの生成
				$b_msg_id = response()->issueMsgId();
				// 小数点以下切り捨て
				$damage = (int)($sicked_pokemon->getStats('H') / 8);
				if($damage < 1){
					// 最小ダメージ数は1
					$damage = 1;
				}
				// HPバーのアニメーション用レスポンス
				response()->setResponse([
					'param' => $damage,
					'action' => 'hpbar',
					'target' => $sicked_pokemon->getPosition(),
				], $b_msg_id);
				// メッセージ
				response()->setAutoMessage($b_msg_id);
				response()->setMessage(
					ScBind::getTurnMessage($sicked_pokemon->getPrefixName(), $sicked_pokemon->getScOther('ScBind'))
				);
				// ダメージ計算(アニメーション後に実施)
				$sicked_pokemon->calRemainingHp('sub', $damage);
				// HPが０になっていればチェック終了
				if(!$sicked_pokemon->getRemainingHp()){
					return;
				}
			}
		}
		/**
		* かなしばり
		*/
		if($sicked_pokemon->isSc('ScDisable')){
			// ターンを進める
			$sicked_pokemon->goScTurn('ScDisable');
			if(!$sicked_pokemon->isSc('ScDisable')){
				// かなしばり解除
				response()->setMessage(
					ScDisable::getRecoveryMessage($sicked_pokemon->getPrefixName())
				);
			}
		}
	}

}
