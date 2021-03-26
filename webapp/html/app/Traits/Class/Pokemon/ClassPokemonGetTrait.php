<?php
/**
* 取得用トレイト
*/
trait ClassPokemonGetTrait
{

    /**
    * IDを取得する
    * @return string
    */
    public function getId(): string
    {
        return $this->id;
    }

    /**
    * ナンバーを取得する
    * @param zero_fill:boolean
    * @return integer|string
    */
    public function getNumber(bool $zero_fill=false)
    {
        if($zero_fill){
            // ゼロ埋め
            $zero = '';
            // ゼロ必要数の算出
            $zero_count = 3 - strlen(static::NUMBER);
            for ($i=0; $i < $zero_count; $i++) {
                $zero = $zero.'0';
            }
            // ゼロ埋め返却
            return $zero.static::NUMBER;
        }else{
            // ナンバー返却
            return static::NUMBER;
        }
    }

    /**
    * 画像の取得
    * @param pause:string::front|back|mini
    * @param transform:boolean
    * @return string::data:base64
    */
    public function base64(string $pause='front', bool $transform=false): string
    {
        if(
            $transform &&
            $this->isSc('ScTransform')
        ){
            $pokemon = $this->getTransform()->pokemon;
        }else{
            $pokemon = get_class($this);
        }
        // base64画像を取得
        return base64_pokemon($pokemon, $pause);
    }

    /**
    * 名前の手前に接頭語を付ける（相手の）
    * @return string
    */
    public function getPrefixName(): string
    {
        if($this->position === 'enemy'){
            return '相手の'.$this->getNickname();
        }else{
            return $this->getNickname();
        }
    }

    /**
    * ニックネームを取得する
    * @return string
    */
    public function getNickname(): string
    {
        if(empty($this->nickname)){
            return static::NAME;
        }
        return $this->nickname;
    }

    /**
    * 立場を取得する
    * @return string
    */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
    * 進化後のクラスを取得する
    * @return string
    */
    public function getAfterClass(): string
    {
        // 定数→プロパティの順番で取得
        return static::AFTER_CLASS ?? $this->after_class;
    }

    /**
    * タイプ名の取得
    * @return array
    */
    public function getTypeNames(): array
    {
        return array_map(function($type){
            return $type::NAME;
        }, static::TYPES);
    }

    /**
    * 覚えている技を取得する
    * @param order:integer
    * @return array
    */
    public function getMove($order=null): array
    {
        if(is_null($order)){
            // 全返却
            return $this->move;
        }else{
            // 番号指定で返却
            return $this->move[$order] ?? $this->move[0];
        }
    }

    /**
    * 進化フラグを取得する
    * @return boolean
    */
    public function getEvolveFlg(): bool
    {
        return $this->evolve_flg;
    }

    /**
    * 現在のレベルを取得する
    * @return integer
    */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
    * 現在の経験値を取得する
    * @return integer
    */
    public function getExp(): int
    {
        return $this->exp;
    }

    /**
    * 努力値を取得する
    * @return array
    */
    public function getEv(): array
    {
        return $this->ev;
    }

    /**
    * 努力値の達成割合を取得する
    * @param key:string
    * @return float
    */
    public function getEvPer($key=''): float
    {
        return ($this->ev[$key] ?? 0) / 252 * 100;
    }

    /**
    * 個体値を取得する
    * @return array
    */
    public function getIv(): array
    {
        return $this->iv;
    }

    /**
    * 個体値を取得する
    * @param key:string
    * @return int
    */
    public function getIvRank($key): int
    {
        $rank = floor($this->iv[$key] / 6);
        if($this->iv[$key] % 6){
            $rank = 1;
        }
        return $rank;
    }

    /**
    * 次のレベルに必要な経験値
    * @return integer
    */
    public function getReqLevelUpExp()
    {
        if($this->level >= 100){
            return 0;
        }
        return ($this->level + 1) ** 3 - $this->exp;
    }

    /**
    * 現在から次のレベルまでの経験値達成率
    * @return float
    */
    public function getPerCompNexExp(): float
    {
        if($this->level >= 100){
            return 100;
        }
        // 現在のレベルので経験値達成率を％の数値で返却（int）
        // 現在のレベルで必要な経験値の超過分（余り）
        $surplus = $this->exp - ($this->level ** 3);
        // 現在のレベルから次のレベルに必要な経験値量
        $need = ((($this->level + 1) ** 3) - ($this->level ** 3));
        // 割合計算（％の数値で返却）
        return $surplus / $need * 100;
    }

    /**
    * 現在の状態異常を取得する
    * @param string::class|turn|all
    * @return mixed
    */
    public function getSa(string $param='class')
    {
        // そのまま返却
        if($param === 'all'){
            return $this->sa;
        }
        // 空の場合は空文字列を返却
        if(empty($this->sa)){
            return '';
        }
        // 取得対象の分岐
        if($param === 'turn'){
            // 経過ターン数を返却
            return $this->sa[array_key_first($this->sa)];
        }else{
            // クラス名を返却
            return array_key_first($this->sa);
        }
    }

    /**
    * 残りHPを取得
    * @return return:string::per|color
    * @return mixed
    */
    public function getRemainingHp(string $return='')
    {
        // 全返却
        if(empty($return)){
            return $this->remaining_hp;
        }
        // 割合を算出
        $per = $this->remaining_hp / $this->getStats('H') * 100;
        // パーセンテージを返却
        if($return === 'per'){
            return $per;
        }
        // カラーを返却
        if($return === 'color'){
            // 赤
            if($per <= 20) return 'danger';
            // 黄色
            if($per <= 50) return 'warning';
            // 緑
            return 'success';
        }
    }

    /**
    * 現在の状態異常（Sa）の名称を取得する
    * @param fainting:boolean
    * @return string
    */
    public function getSaName(bool $fainting=true): string
    {
        if(empty($this->sa)){
            return '';
        }
        // ひんしの場合は不要
        if(
            !$fainting &&
            isset($this->sa['SaFainting'])
        ){
            return '';
        }
        // 状態異常を取得
        $class = array_key_first($this->sa);
        return $class::NAME;
    }

    /**
    * 現在の状態異常（Sa）の色を取得する
    * @param fainting:boolean
    * @return string
    */
    public function getSaColor(bool $fainting=true): string
    {
        if(empty($this->sa)){
            return '';
        }
        // ひんしの場合は不要（バトル画面など）
        if(
            !$fainting &&
            isset($this->sa['SaFainting'])
        ){
            return '';
        }
        $class = array_key_first($this->sa);
        return $class::COLOR;
    }

    /**
    * 全テータスの取得
    * @return array
    */
    public function getStatsAll(): array
    {
        $stats = [];
        foreach(array_keys(config('pokemon.stats.default')) as $key){
            $stats[$key] = $this->getStats($key);
        }
        return $stats;
    }

    /**
    * ステータスの取得
    * @param key:string
    * @return integer
    */
    public function getStats(string $key): int
    {
        /**
        * ステータスの計算式（小数点以下は切り捨て）
        * HP：(種族値×2+個体値+努力値÷4)×レベル÷100+レベル+10
        * HP以外：(種族値×2+個体値+努力値÷4)×レベル÷100+5
        */
        if($key === 'H'){
            $correction = $this->level + 10;
        }else{
            $correction = 5;
        }
        return (static::BASE_STATS[$key] * 2 + $this->iv[$key] + $this->ev[$key] / 4) * $this->level / 100 + $correction;
    }

    /**
    * 現在のレベルで覚えられる技の数を取得する処理
    * @return integer
    */
    public function getLevelMoveCount(): int
    {
        $level_move_keys = array_keys(
            array_column(static::LEVEL_MOVE, 0),
            $this->level
        );
        return count($level_move_keys);
    }

}
