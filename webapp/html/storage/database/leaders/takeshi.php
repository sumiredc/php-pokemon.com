<?php
return [
    'id' => basename(__FILE__, '.php'),
    'name' => 'タケシ',
    'money' => 2000,
    'lines' => [
        'lose' => [
            '君を見くびっていたようだ',
            '僕に勝った証に、ポケモンリーグ公認グレーバッジを授けよう！'
        ],
        'win' => '再び力をつけて挑んできたまえ',
    ],
    'party' => [
        [   # 1匹目（イシツブテ）
            'class' => 'Ishitsubute',
            'level' => 12,
            'iv' => ['H' => 31, 'A' => 31, 'B' => 31, 'C' => 31, 'D' => 31, 'S' => 31],
            'ev' => ['H' => 252, 'A' => 252, 'B' => 6, 'C' => 252, 'D' => 0, 'S' => 0],
            'move' => [
                // たいあたり・まるくなる・がまん
                'MoveTackle', 'MoveDefenseCurl', 'MoveBide'
            ],
        ],
        [   # 2匹目（イワーク）
            'class' => 'Iwark',
            'level' => 14,
            'iv' => ['H' => 31, 'A' => 31, 'B' => 31, 'C' => 31, 'D' => 31, 'S' => 31],
            'ev' => ['H' => 252, 'A' => 0, 'B' => 6, 'C' => 0, 'D' => 0, 'S' => 252],
            'move' => [
                // たいあたり・いやなおと・しめつける・いわおとし
                'MoveTackle', 'MoveScreech', 'MoveBind', 'MoveRockThrow'
            ],
        ],
        [   # 3匹目（カブト）
            'class' => 'Kabuto',
            'level' => 16,
            'iv' => ['H' => 31, 'A' => 31, 'B' => 31, 'C' => 31, 'D' => 31, 'S' => 31],
            'ev' => ['H' => 6, 'A' => 252, 'B' => 0, 'C' => 252, 'D' => 0, 'S' => 0],
            'move' => [
                // ひっかく・かたくなる・すいとる・あなをほる
                'MoveScratch', 'MoveHarden', 'MoveAbsorb', 'MoveDig'
            ],
        ],
    ],
];
