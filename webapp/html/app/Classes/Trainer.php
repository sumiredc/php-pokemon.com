<?php
/**
* トレーナー情報
*/
class Trainer
{

	/**
	* ID（拡張子を除いたファイル名）
	* @var string
	*/
	protected $id = '';

	/**
	* 名前
	* @var string
	*/
	protected $name = '';

	/**
	* パーティー
	* @var array
	*/
	protected $party = [];

	/**
	* 持ち物
	* [[class => string, count => int|null], ...]
	* @var array
	*/
	protected $items = [];

	/**
	* セリフ
	* @var array
	*/
	protected $lines = [
		'win' => '修行が必要だね',
		'lose' => '次は勝つよ',
	];

	/**
	* 賞金
	* @var integer
	*/
	protected $money = 100;

	/** @var string */
	protected $category;
	protected $gym;

	/**
	* @param trainer:array
	* @param string $category
	* @return void
	*/
	public function __construct(array $trainer, string $category)
	{
		$this->init($trainer, $category);
	}

	/**
	* 初期化
	* @param trainer:array
	* @param string $category
	* @return void
	*/
	private function init(array $trainer, string $category): void
	{
		// トレーナーカテゴリ
		$this->category = $category;
		// トレーナーIDの格納
		$this->id = $trainer['id'];
		// トレーナー名の生成
		$this->name = $trainer['name'];
		// パーティーの生成
		$this->generateParty($trainer['party']);
		// セリフの格納
		if(isset($trainer['lines'])){
			$this->lines = $trainer['lines'];
		}
		// 賞金
		if(isset($trainer['money'])){
			$this->money = $trainer['money'];
		}
		// ジムリーダー用のジムクラス格納処理
		if($category === 'leader'){
			$this->gym = $trainer['gym'];
		}
	}

	/**
	* パーティーの生成
	* @param party:array
	* @return void
	*/
	private function generateParty(array $party): void
	{
		$this->party = array_map(function($data){
			// ポケモンのインスタンスを生成
			$pokemon = new $data['class']($data['level'] ?? 10);
			// トレーナー用のポケモンに書き換え
			return $pokemon->initTrainerPokemon($data);
		}, $party);
	}

	/**
	* IDの取得
	* @return string
	*/
	public function getId(): string
	{
		return $this->id;
	}

	/**
	* 名前の取得
	* @return string
	*/
	public function getName(): string
	{
		return $this->name;
	}

	/**
	* カテゴリ名付きの名前を取得
	* @return string
	*/
	public function getPrefixName(): string
	{
		return $this->getCategoryName().'の'.$this->name;
	}

	/**
	* トレーナーカテゴリを取得
	* @return string
	*/
	public function getCategory(): string
	{
		return $this->category;
	}

	/**
	* トレーナー画像パスの取得
	* @param string $pause
	* @return string
	*/
	public function getImagePath(string $pause='front'): string
	{
		switch ($this->category) {
			// ジムリーダー
			case 'leader':
			$path = assets_uri('img/gym/leader/'.$pause.'/'.$this->id.'.gif');
			break;
			// 通常トレーナー
			default:
			$path = assets_uri('img/npc/front/'.$this->category.'.gif');
			break;
		}
		return $path;
	}

	/**
	* トレーナーカテゴリ名を取得
	* @return string
	*/
	public function getCategoryName(): string
	{
		if($this->category === 'leader'){
			return 'ジムリーダー';
		}
		return config('trainer.'.$this->category.'.name');
	}

	/**
	* パーティーを取得
	* @return array
	*/
	public function getParty(): array
	{
		return $this->party;
	}

	/**
	* 所有数を取得
	* @return integer
	*/
	public function getPartyCount(): int
	{
		return count($this->party);
	}

	/**
	* 空き数を取得
	* @return array
	*/
	public function getPartyEmptyCount(): int
	{
		return 6 - count($this->party);
	}

	/**
	* セリフの取得
	* @param situation:string
	* @return array
	*/
	public function getLine(string $situation): array
	{
		if(isset($this->lines[$situation])){
			// 配列として処理
			return array_map(function($line){
				return '「'.($line).'」';
			}, (array)$this->lines[$situation]);
		}else{
			return ['「...」'];
		}
	}

	/**
	* 賞金の取得
	* @return integer
	*/
	public function getMoney(): int
	{
		return $this->money;
	}

	/**
	* ジム情報の取得
	* @return string
	*/
	public function getGym(): string
	{
		return $this->gym ?? '';
	}

	/**
	* ポケモン情報を取得
	* @param order:integer
	* @return object::Pokemon|null
	*/
	public function getPartner(int $order)
	{
		return $this->party[$order] ?? null;
	}

}
