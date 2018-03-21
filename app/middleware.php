<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$container = $app->getContainer();

$app->add(
    new \Tuupola\Middleware\Cors(
        $settings['settings']['cors']
    )
);
