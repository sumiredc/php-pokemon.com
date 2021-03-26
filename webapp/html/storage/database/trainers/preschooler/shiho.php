<?php
return [
    'id' => basename(__FILE__, '.php'),
    'name' => 'シホ',
    'money' => 50,
    'lines' => [
        'lose' => '負けちゃったー',
        'win' => 'やったー！',
    ],
    'party' => [
        [   # 1匹目（ポッポ）
            'class' => 'Poppo',
            'level' => 3,
        ],
        [   # 2匹目（ゼニガメ）
            'class' => 'Zenigame',
            'level' => 3,
        ],
    ],
];
