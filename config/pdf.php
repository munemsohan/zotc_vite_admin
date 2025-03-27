<?php
return
    [
        'mode'                  => 'utf-8',
        'format'                => 'A4',
        'author'                => '',
        'subject'               => '',
        'keywords'              => '',
        'creator'               => 'Laravel Pdf',
        'display_mode'          => 'fullpage',
        'tempDir'               => base_path('temp/'),
        'font_path'             => public_path('assets/fonts/'),
        'font_data' => [
            'roboto' => [
                'R'  => 'Roboto-Regular.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'hindsiliguri' => [
                'R'  => 'HindSiliguri-Regular.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'arnamu' => [
                'R'  => 'arnamu.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'varelaround' => [
                'R'  => 'VarelaRound-Regular.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'hanuman' => [
                'R'  => 'Hanuman-Regular.ttf',
                'useOTL' => 0xFF,
                'useKashida' => 75,
            ],
            'kanit' => [
                'R'  => 'Kanit-Regular.ttf',
            ],
            'yahei' => [
                'R'  => 'chinese-msyh.ttf',
            ],
            'pyidaungsu' => [
                'R'  => 'Pyidaungsu.ttf',
            ],
            'zawgyi-one' => [
                'R'  => 'Zawgyi-One.ttf',
            ]
        ]
    ];
