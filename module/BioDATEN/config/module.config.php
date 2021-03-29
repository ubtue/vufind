<?php

namespace BioDATEN\Module\Config;

$config = [
    'service_manager' => [
        'factories' => [
            'BioDATEN\RecordDriver\PluginManager' => 'VuFind\ServiceManager\AbstractPluginManagerFactory',
        ],
        'aliases' => [
            'VuFind\RecordDriverPluginManager' => 'BioDATEN\RecordDriver\PluginManager',
            'VuFind\RecordDriver\PluginManager' => 'BioDATEN\RecordDriver\PluginManager',
        ],
    ],
];

$recordRoutes = [];
$dynamicRoutes = [];
$staticRoutes = [];

$routeGenerator = new \VuFind\Route\RouteGenerator();
$routeGenerator->addRecordRoutes($config, $recordRoutes);
$routeGenerator->addDynamicRoutes($config, $dynamicRoutes);
$routeGenerator->addStaticRoutes($config, $staticRoutes);

return $config;
