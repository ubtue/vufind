<?php

namespace BioDATEN\Module\Config;

$config = [

];

$recordRoutes = [];
$dynamicRoutes = [];
$staticRoutes = [];

$routeGenerator = new \VuFind\Route\RouteGenerator();
$routeGenerator->addRecordRoutes($config, $recordRoutes);
$routeGenerator->addDynamicRoutes($config, $dynamicRoutes);
$routeGenerator->addStaticRoutes($config, $staticRoutes);

return $config;
