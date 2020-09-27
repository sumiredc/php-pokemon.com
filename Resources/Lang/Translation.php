<?php

function transJp($str)
{
    $array = [
        'attack' => 'こうげき',
        'defense' => 'ぼうぎょ',
        'spatk' => 'とくこう',
        'spdef' => 'とくぼう',
        'speed' => 'すばやさ',
        'name' => '正式名称',
        'nickname' => 'ニックネーム',
        'type' => 'タイプ',
        'level' => 'レベル',
        'exp' => '経験値',
        'nextlevel' => '次のレベルまで',
        'physical' => '物理',
        'special' => '特殊',
        'status' => '変化',
    ];
    // 小文字変換して配列から取得、存在しなければそのまま返却
    return $array[mb_strtolower($str)] ?? $str;
}
