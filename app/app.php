<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Set up config

$config = new \Agora\Modules\Config\Config();

$settings = $config->getConfig();

$app = new \Slim\App($settings);

// Set up dependencies
require_once 'dependencies.php';

// Register middleware
require_once 'middleware.php';

$routes = $settings['settings']['routes']['routes'];

// Register routes
new \Agora\Modules\Routes\Routes($app, $routes);

$app->run();
