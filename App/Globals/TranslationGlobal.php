<?php
// 名称翻訳
function transJp($str)
{
    $array = [
        'attack' => 'こうげき',
        'defense' => 'ぼうぎょ',
        'spatk' => 'とくこう',
        'spdef' => 'とくぼう',
        'accuracy' => '命中率',
        'evasion' => '回避率',
        'speed' => 'すばやさ',
        'critical' => '急所率',
        'name' => '正式名称',
        'nickname' => 'ニックネーム',
        'type' => 'タイプ',
        'level' => 'レベル',
        'exp' => '経験値',
        'nextlevel' => '次のレベルまで',
        'physical' => '物理',
        'special' => '特殊',
        'status' => '変化',
        'friend' => '味方',
        'enemy' => '相手',
        'takeshi' => 'タケシ',
        'kasumi' => 'カスミ',
        'machisu' => 'マチス',
        'erika' => 'エリカ',
        'kyou' => 'キョウ',
        'natsume' => 'ナツメ',
        'katsura' => 'カツラ',
        'sakaki' => 'サカキ',
    ];
    // 小文字変換して配列から取得、存在しなければそのまま返却
    return $array[mb_strtolower($str)] ?? $str;
}
