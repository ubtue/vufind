<?php
return [
    'extends' => 'sandal',
    'css' => [
        'biodaten.css'
    ],
    'helpers' => [
        'factories' => [
            'VuFind\View\Helper\Root\RecordDataFormatter' => 'BioDATEN\View\Helper\Root\RecordDataFormatterFactory',
        ],
    ],
];
