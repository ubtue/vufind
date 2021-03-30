<?php
return [
    'extends' => 'sandal',
    'css' => [
        'biodaten.css'
    ],
    'helpers' => [
        'factories' => [
            'VuFind\View\Helper\Root\RecordDataFormatter' => 'BioDATEN\View\Helper\Root\RecordDataFormatterFactory',
            'BioDATEN\View\Helper\BioDATEN\BioDATEN' => 'Laminas\ServiceManager\Factory\InvokableFactory',
        ],
        'aliases' => [
            'biodaten' => 'BioDATEN\View\Helper\BioDATEN\BioDATEN',
        ],
    ],
];
