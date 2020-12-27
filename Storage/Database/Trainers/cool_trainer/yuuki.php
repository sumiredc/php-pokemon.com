<?php
return [
    'id' => basename(__FILE__, '.php'),
    'name' => 'ユウキ',
    'money' => 500,
    'lines' => [
        'lose' => 'やるね',
        'win' => 'まだまだだね',
    ],
    'party' => [
        [   # 1匹目（ライチュウ）
            'class' => 'Raichu',
            'level' => 10,
            'move' => [
                'MoveThunder', 'MoveGrowl', 'MoveQuickAttack', 'MoveMegaPunch'
            ],
        ],
        [   # 2匹目（ピジョン）
            'class' => 'Pigeon',
            'level' => 12,
        ],
        [   # 3匹目（ヒトカゲ）
            'class' => 'Hitokage',
            'level' => 13,
            'ev' => [
                'H' => '6',
                'A' => '0',
                'B' => '0',
                'C' => '252',
                'D' => '0',
                'S' => '252',
            ],
        ],
    ],
];
