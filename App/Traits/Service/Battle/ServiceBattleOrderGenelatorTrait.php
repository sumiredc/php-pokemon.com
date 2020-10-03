<?php
// 行動順の配列生成用トレイト
trait ServiceBattleOrderGenelatorTrait
{

    /**
    * 行動順の判定
    * （行動順判定用数値を生成）
    * @var 100万の位：優先度
    * @var 10〜10万の位：すばやさ
    * @var 1の位：乱数
    * @param array [攻撃ポケモン, 防御ポケモン, 攻撃ポケモンの技]
    * @return array [行動順判定用数値 => [攻撃ポケモン, 防御ポケモン, 技],...]
    */
    protected function orderMove(...$pokemons)
    {
        $results = [];
        foreach($pokemons as list($atk, $def, $move)){
            // 優先度のセット
            $speed = $move->getPriority() * 1000000;
            // 素早さ実数値の加算
            $speed += $atk->getStats('Speed', true) * 10;
            // 乱数の生成(同速判定用)
            $key = $speed + random_int(0, 9);
            // 重複回避
            while(isset($results[$key])){
                $key = $speed + random_int(0, 9);
            }
            // 配列へセット
            $results[$key] = [$atk, $def, $move];
        }
        // 降順（行動が早い順）に並び替え
        krsort($results);
        return $results;
    }

    /**
    * 行動順の判定(すばやさのみでの判定※技の優先度関係なし)
    * （行動順判定用数値を生成）
    * @var 10〜10万の位：すばやさ
    * @var 1の位：乱数
    * @param array [攻撃ポケモン, 防御ポケモン]
    * @return array [行動順判定用数値 => [攻撃ポケモン, 防御ポケモン],...]
    */
    protected function orderSpeed(...$pokemons)
    {
        $results = [];
        foreach($pokemons as list($atk, $def)){
            // 素早さ実数値の加算
            $speed = $atk->getStats('Speed', true) * 10;
            // 乱数の生成(同速判定用)
            $key = $speed + random_int(0, 9);
            // 重複回避
            while(isset($results[$key])){
                $key = $speed + random_int(0, 9);
            }
            // 配列へセット
            $results[$key] = [$atk, $def];
        }
        // 降順（行動が早い順）に並び替え
        krsort($results);
        return $results;
    }

}
