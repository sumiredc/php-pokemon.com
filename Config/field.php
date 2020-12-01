<?php
# フィールド情報
return [
    'route_1' => [
        'name' => '1番道路',
        'level' => 1, # プレイヤーレベル
        'pokemon' => [
            'Nyarth', 'Poppo'
        ],
        'min' => 2,   # 出現する最小レベル
        'max' => 5,   # 出現する最大レベル
    ],
    'route_2' => [
        'name' => '2番道路',
        'level' => 4,
        'pokemon' => [
            'Nyarth', 'Poppo', 'Pikachu'
        ],
        'min' => 3,
        'max' => 7,
    ],
    'viridian_forest' => [
        'name' => 'トキワの森',
        'level' => 8,
        'pokemon' => [
            'Pikachu', 'Poppo', 'Fushigidane', 'Hitokage', 'Zenigame', 'Nyarth'
        ],
        'min' => 7,
        'max' => 13,
    ],
    'rock_tunnel' => [
        'name' => 'イワヤマトンネル',
        'level' => 18,
        'pokemon' => [
            'Fushigisou', 'Lizardo', 'Kameil', 'Metamon', 'Pigeon', 'Persian', 'Pikachu', 'Nyarth'
        ],
        'min' => 13,
        'max' => 28,
    ],
    'victory_road' => [
        'name' => 'チャンピオンロード',
        'level' => 40,
        'pokemon' => [
            'Fushigisou', 'Lizardo', 'Kameil', 'Fushigibana', 'Lizardon', 'Kamex', 'Raichu', 'Pigeot', 'Persian'
        ],
        'min' => 38,
        'max' => 52,
    ],
    'cerulean_cave' => [
        'name' => 'ハナダの洞窟',
        'level' => 90,
        'pokemon' => [
            'Mew', 'Pikachu', 'Raichu'
        ],
        'min' => 82,
        'max' => 95,
    ],
];
