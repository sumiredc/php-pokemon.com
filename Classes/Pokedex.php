<?php
$root_path = __DIR__.'/..';

// ポケモン図鑑
class Pokedex
{

    /**
    * ポケモン図鑑([pokemon_number => int])
    * 0: 未発見
    * 1: 見つけた
    * 2: 捕まえた
    * @var array
    */
    protected $pokedex = [];

    /**
    * 図鑑情報の取得
    * @return array
    */
    public function get(): array
    {
        return $this->pokedex;
    }

    /**
    * 登録数の取得
    * @param sort:integer (1:見つけた数 2:捕まえた数)
    * @return integer
    */
    public function getCount($sort=0): int
    {
        if(empty($sort)){
            return 0;
        }
        // 番号でソート
        $result = array_filter($this->pokedex, function($status) use($sort){
            return $status >= $sort;
        });
        return count($result);
    }

    /**
    * 図鑑の登録状況を確認
    * @param number:integer
    * @return integer
    */
    public function isRegisted(int $number): int
    {
        return $this->pokedex[$number] ?? 0;
    }

    /**
    * 発見
    * @param pokemon:string|object::Pokemon
    * @return void
    */
    public function discovery($pokemon): void
    {
        // オブジェクトを受け取った際はクラスを取得
        if(is_object($pokemon)){
            $pokemon = get_class($pokemon);
        }
        // 発見済みの場合は処理中断
        if(($this->pokedex[$pokemon::NUMBER] ?? 0) >= 1){
            return;
        }
        // 追加
        $this->pokedex[$pokemon::NUMBER] = 1;
        // 図鑑の歯抜けを空データで埋める
        $this->fillSpace();
    }

    /**
    * 登録
    * @param pokemon:object::Pokemon
    * @return void
    */
    public function regist(object $pokemon): void
    {
        // 発見済みの場合は処理中断
        if(
            !is_a($pokemon, 'Pokemon') ||
            ($this->pokedex[$pokemon->getNumber()] ?? 0) >= 2
        ){
            return;
        }
        // 追加
        $this->pokedex[$pokemon->getNumber()] = 2;
        // 図鑑の歯抜けを空データで埋める
        $this->fillSpace();
    }


    /**
    * 図鑑の歯抜けを空データで埋める
    * @return void
    */
    private function fillSpace(): void
    {
        // まずキーを基準に並び替えをする
        ksort($this->pokedex);
        // 最初と最後のキーを取得
        $first = array_key_first($this->pokedex);
        $last = array_key_last($this->pokedex);
        // 現在の図鑑の最初から最後までの番号の空データを作成
        $empty_array = array_fill($first, $last - $first + 1, 0);
        // 空配列と図鑑のポケモンの数が同じの場合は埋め処理不要
        if(count($empty_array) === count($this->pokedex)){
            return;
        }
        // 配列を加算（array_mergeは番号が採番されるため使用しない）
        $this->pokedex += $empty_array;
        // 最後に再度並び替えを実行
        ksort($this->pokedex);
    }

}
