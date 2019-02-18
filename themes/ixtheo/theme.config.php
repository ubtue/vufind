<?php
return [
    'extends' => 'tuefind',
    'css' => [
        'compiled.css',
        'feedback.css',
        'vendor/jquery.feedback_me.css',
    ],
    'helpers' => [
        'factories' => [
            'IxTheo\View\Helper\Root\Browse' => 'Zend\ServiceManager\Factory\InvokableFactory',
            'IxTheo\View\Helper\Root\Citation' => 'IxTheo\View\Helper\Root\CitationFactory',
            'IxTheo\View\Helper\Root\IxTheo' => 'Zend\ServiceManager\Factory\InvokableFactory',
            'IxTheo\View\Helper\Root\Record' => 'IxTheo\View\Helper\Root\RecordFactory',
        ],
        'aliases' => [
            'browse' => 'IxTheo\View\Helper\Root\Browse',
            'citation' => 'IxTheo\View\Helper\Root\Citation',
            'ixtheo' => 'IxTheo\View\Helper\Root\IxTheo',
            'record' => 'IxTheo\View\Helper\Root\Record',
        ],
    ],
    'js' => [
        'ixtheo.js',
    ],
];