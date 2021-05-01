<?php

require_once app_path('Classes/Pokemon.php');

/**
* バトル中のみ使用するメソッド用トレイト
*/
trait ClassPokemonBattleTrait
{

	/**
	* バトル用専用ステータスの初期化(ランク・状態変化)
	* @return void
	*/
	public function initBattleStats(): void
	{
		$this->initSc();
		$this->initRank();
		$this->initSaBadPoison();
	}

	/**
	* バトル用の技リストを取得
	* @param order:integer
	* @return array
	*/
	public function getBattleMove($order=null): array
	{
		if($this->isSc('ScTransform')){
			$move = $this->getTransform()->move;
		}else{
			$move = $this->move;
		}
		if(is_null($order)){
			return $move;
		}else{
			return $move[$order] ?? [];
		}
	}

	/**
	* 猛毒の解除（通常どくに変換）
	* @param clsas:string
	* @return void
	*/
	public function initSaBadPoison(): void
	{
		if($this->getSa() === 'SaBadPoison'){
			$this->setSa('SaPoison');
		}
	}

	/**==================================================================
	* ランク関係処理
	==================================================================**/

	/**
	* 状態変化の解除
	* @param clsas:string
	* @return void
	*/
	public function initSc(string $class=''): void
	{
		if(empty($class)){
			// 全解除
			$this->sc = [];
		}else{
			// 指定された状態変化の解除
			unset($this->sc[$class]);
		}
	}

	/**
	* ランクの初期化
	* @param key:string
	* @return void
	*/
	public function initRank($key=''): void
	{
		if(empty($key)){
			// 全ランク初期化
			$this->rank = config('rank.default');
		}else{
			// ランク指定で初期化
			if(isset($this->rank[$key])){
				$this->rank[$key] = 0;
			}
		}
	}

	/**
	* ランク（バトルステータス）の取得
	* @param key:string
	* @return array|integer
	*/
	public function getRank(string $key='')
	{
		// ランクを変数に格納
		if($this->isSc('ScTransform')){
			// へんしんオブジェクトを参照
			$rank = $this->getTransform()->rank;
		}else{
			// ステータスを参照
			$rank = $this->rank;
		}
		/**
		* ロケットずつき待機中は防御＋1補正
		* 1.ロケットずつきのチャージ状態
		* 2.ぼうぎょランクが+6以下
		*/
		if(
			$this->isChargeMove('MoveSkullBash') &&
			$rank['B'] < 6
		){
			$rank['B']++;
		}
		// パラメーターに合わせた返り値の分岐
		if(empty($key)){
			return $rank;
		}else{
			return $rank[$key];
		}
	}

	/**
	* ランクの加算
	* @param key:string
	* @param val:integer::min:1|max:12
	* @return string
	*/
	public function addRank(string $key, int $val): string
	{
		// 既にランクが最大であればfalseを返却
		if($this->rank[$key] === 6){
			return $this->getPrefixName().'の'.transJp($key, 'stats').'はもう上がらない';
		}
		// 加算処理
		$this->rank[$key] += $val;
		// 最大値は6
		if($this->rank[$key] > 6){
			$this->rank[$key] = 6;
		}
		return $this->getPrefixName().'の'.transJp($key, 'stats').'が'.(config('rank.buff.'.$val) ?? config('rank.buff.3'));
	}

	/**
	* ランクの減算
	* @param key:string
	* @param val:integer::min:1|max:3
	* @return string
	*/
	public function subRank(string $key, int $val): string
	{
		// 既にランクが最低であればfalseを返却
		if($this->rank[$key] === -6){
			return $this->getPrefixName().'の'.transJp($key, 'stats').'はもう下がらない';
		}
		// 減算処理
		$this->rank[$key] -= $val;
		// 最低値は-6
		if($this->rank[$key] < -6){
			$this->rank[$key] = -6;
		}
		return $this->getPrefixName().'の'.transJp($key, 'stats').'が'.(config('rank.debuff.'.$val) ?? config('rank.debuff.3'));
	}

	/**==================================================================
	* ステータス関係処理
	==================================================================**/

	/**
	* 補正値込みの全ステータスの取得
	* @return array
	*/
	public function getStatsMAll(): array
	{
		$stats = [];
		foreach(array_keys(config('pokemon.stats.default')) as $key){
			// HPはランク補正不要
			if($key === 'H'){
				$stats[$key] = $this->getStats($key);
			}else{
				$stats[$key] = $this->getStatsM($key);
			}
		}
		return $stats;
	}

	/**
	* 補正値込みのステータスの取得
	* @param key:string
	* @return integer
	*/
	public function getStatsM(string $key): int
	{
		// 対象ステータスの実数値を取得
		$stats = $this->getStats($key);
		// ランク補正
		$rank = $this->getRank($key);
		if($rank >= 0){
			// +補正
			$per = ($rank + 2) / 2;
		}else{
			// -補正
			$per = 2 / (2 - $rank);
		}
		$stats *= round($per, 2); # 四捨五入
		// 状態異常補正
		if(
			$key === 'S' &&
			$this->getSa() === 'SaParalysis'
		){
			// すばやさ半減
			$stats *= 0.5;
		}
		return $stats; # 切り捨てで返却
	}

	/**==================================================================
	* 状態変化処理
	==================================================================**/

	/**
	* 状態変化の取得
	* @param class:string
	* @return array
	*/
	public function getSc(string $class=''): array
	{
		if(empty($class)){
			// 全状態異常を取得
			return $this->sc;
		}else{
			return $this->sc[$class] ?? [];
		}
	}

	/**
	* 状態変化のターン情報を取得
	* @param class:string
	* @return integer
	*/
	public function getScTurn(string $class): int
	{
		return $this->sc[$class]['turn'] ?? 0;
	}

	/**
	* 状態変化のパラメーターを取得
	* @param class:string
	* @return mixed
	*/
	public function getScOther(string $class)
	{
		return $this->sc[$class]['other'] ?? null;
	}

	/**
	* 状態変化をセットする
	* @param class:string
	* @param turn:integer
	* @param other:mixed
	* @return string
	*/
	public function setSc(string $class, $turn=0, $other=''): string
	{
		// 状態変化のセット確認
		if(isset($this->sc[$class])){
			// 既に同じ状態変化にかかっている
			if(is_string($other)){
				return $class::getSickedAlreadyMessage($this->getPrefixName(), $other);
			}
		}else{
			// 状態変化をセット
			$this->sc[$class] = [
				'turn' => $turn,
				'other' => $other,
			];
			return $class::getSickedMessage($this->getPrefixName(), $other);
		}
	}

	/**
	* 状態変化の確認用メソッド
	* @param key:string
	* @return boolean
	*/
	public function isSc(string $key): bool
	{
		return isset($this->sc[$key]);
	}

	/**
	* チャージ技の確認
	* @param move:string
	* @return boolean
	*/
	public function isChargeMove(string $move): bool
	{
		return $this->getScOther('ScCharge') === $move;
	}

	/**
	* チャージ技を取得 ※getScOtherのラップ
	* @return string
	*/
	public function getChargeMove(): string
	{
		// チャージ状態であれば、技クラスを取得
		return $this->getScOther('ScCharge') ?? '';
	}

	/**
	* あばれる技（クラス）を取得 ※getScOtherのラップ
	* @return string
	*/
	public function getThrashMove(): string
	{
		// あばれる状態であれば、技クラスを取得
		return $this->getScOther('ScThrash') ?? '';
	}

	/**
	* がまん状態時のダメージ蓄積処理
	* @param integer $damage
	* @return App\Classes\Pokemon
	*/
	public function setBideDamage(int $damage): Pokemon
	{
		if(!$this->isSc('ScBide')){
			return $this;
		}
		// ダメージが蓄積されていれば解除
		if(isset($this->sc['ScBide']['damage'])){
			$this->sc['ScBide']['damage'] += $damage;
		}else{
			$this->sc['ScBide']['damage'] = $damage;
		}
		return $this;
	}

	/**
	* がまん蓄積ダメージの取得
	* @return integer
	*/
	public function getBideDamage(): int
	{
		if(
			$this->isSc('ScBide') &&
			isset($this->sc['ScBide']['damage'])
		){
			return $this->sc['ScBide']['damage'] ?? 0;
		}else{
			return 0;
		}
	}

	/**==================================================================
	* へんしん関係処理
	==================================================================**/

	/**
	* へんしん情報の取得 ※getScOrderのラップ
	* @return object::PokemonTransform|null
	*/
	public function getTransform()
	{
		return $this->getScOther('ScTransform');
	}

	/**
	* へんしんポケモンの生成
	* @param pokemon:object::Pokemon
	* @return App\Classes\PokemonTransform
	*/
	public function transform(object $pokemon): PokemonTransform
	{
		// へんしんオブジェクトをインスタンス化
		$transform = new PokemonTransform;
		// へんしんでコピーするステータスとポケモンクラスを格納
		$transform->pokemon = get_class($pokemon);      # 対象ポケモン
		$transform->iv = $pokemon->getIv();             # 個体値
		$transform->ev = $pokemon->getEv();             # 努力値
		$transform->base_stats = $pokemon::BASE_STATS;  # 種族値
		$transform->rank = $pokemon->getRank();         # ランク
		$transform->move = $pokemon->getMove();         # 覚えている技
		// HPは元ポケモンのステータスを使用
		$transform->iv['H'] = $this->iv['H'];
		$transform->ev['H'] = $this->ev['H'];
		$transform->base_stats['H'] = $this::BASE_STATS['H'];
		// 技の残りPPを5にする
		$transform->move = array_map(function($move){
			$move['remaining'] = 5;
			$move['correction'] = 0;
			return $move;
		}, $this->move);
		// 生成したオブジェクトを返却
		return $transform;
	}

}
