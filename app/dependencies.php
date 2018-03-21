<?php
// DI Configuration
$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

//Slim app
$container['slim'] = function ($c) {
    global $app;
    return $app;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(
        new \Monolog\Handler\StreamHandler(
            $settings['logger']['path'],
            \Monolog\Logger::DEBUG
        )
    );
    
    return $logger;
};

//Slim CSRF
$container['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard();

    $guard->setFailureCallable(
        function (
            $request,
            $response,
            $next
        ) {
            $request = $request->withAttribute("csrf_status", false);
            return $next($request, $response);
        }
    );
    return $guard;
};

// Doctrine
$container['em'] = function ($c) {
    $settings = $c->get('settings');
    
    $isDevMode = ($settings['mode'] == 'development');

    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $isDevMode,
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        $settings['useSimpleAnnotationReader']
    );
    $em = \Doctrine\ORM\EntityManager::create(
        $settings['doctrine']['connection'],
        $config
    );
    return $em;
};

$container['bundles'] = function ($c) {
    $settings = $c->get('settings');

    $isDevMode = ($settings['mode'] == 'development');

    if ($isDevMode) {
        $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
    }
    
    return $bundles;
};

//Mailer
$container['mailer'] = function ($c) {
    $settings = $c->get('settings');
    
    $options = new \PHPMailer();

    $options->Host = $settings['mail']['host'];
    $options->SMTPAuth = $settings['mail']['auth'];
    $options->SMTPSecure = $settings['mail']['secure'];
    $options->Port = $settings['mail']['port'];
    $options->Username = $settings['mail']['username'];
    $options->isHTML($settings['mail']['is_html']);

    $mailer = new \Agora\Modules\Mailer\Mailer($c->view, $options);
    
    return $mailer;
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------
$container['Agora\Bundles\Users\Controller\Controller'] = function ($c) {
    $resource = new \Agora\Bundles\Users\Actions\Action($c);
    $users = new Agora\Bundles\Users\Controller\Controller($resource);
    return $users;
};

$container['Agora\Bundles\Address\Controller\Controller'] = function ($c) {
    $resource = new \Agora\Bundles\Address\Actions\Action($c);
    $address = new Agora\Bundles\Address\Controller\Controller($resource);
    return $address;
};

$container['Agora\Bundles\Industries\Controller\Controller'] = function ($c) {
    $resource = new \Agora\Bundles\Industries\Actions\Action($c);
    $industries = new Agora\Bundles\Industries\Controller\Controller($resource);
    return $industries;
};

$container['Agora\Bundles\Locations\Controller\Controller'] = function ($c) {
    $resource = new \Agora\Bundles\Locations\Actions\Action($c);
    $locations = new Agora\Bundles\Locations\Controller\Controller($resource);
    return $locations;
};

$container['Agora\Bundles\Roles\Controller\Controller'] = function ($c) {
    $resource = new \Agora\Bundles\Roles\Actions\Action($c);
    $roles = new Agora\Bundles\Roles\Controller\Controller($resource);
    return $roles;
};

$container['Agora\Bundles\Contact\Controller\Controller'] = function ($c) {
    $resource = new \Agora\Bundles\Contact\Actions\Action($c);
    $contact = new Agora\Bundles\Contact\Controller\Controller($resource);
    return $contact;
};

$container['Agora\Bundles\Pages\Controller\Controller'] = function ($c) {
    $resource = new \Agora\Bundles\Pages\Actions\Action($c);
    $page = new Agora\Bundles\Pages\Controller\Controller($resource);
    return $page;
};
