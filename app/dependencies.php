<?php
/**
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category  Agora
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */
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
            $request = $request->withAttribute('csrf_status', false);

            return $next($request, $response);
        }
    );

    return $guard;
};

// Doctrine
$container['em'] = function ($c) {
    $settings = $c->get('settings');

    $isDevMode = ('development' === $settings['mode']);

    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $isDevMode,
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        $settings['useSimpleAnnotationReader']
    );

    //$eventManager = new \Doctrine\Common\EventManager();

    //$listener = new \Agora\Modules\Mailer\MailerListener($c);
    //$eventManager->addEventListener($listener->getSubscribedEvents(), $listener);
    //$eventManager->addEventSubscriber(new \Agora\Modules\Base\Events\BaseEventSubscriber());


    // $em = \Doctrine\ORM\EntityManager::create(
    //     $settings['doctrine']['connection'],
    //     $config,
    //     $eventManager
    // );
    $em = \Doctrine\ORM\EntityManager::create(
        $settings['doctrine']['connection'],
        $config
    );
    return $em;
};

$container['bundles'] = function ($c) {
    $settings = $c->get('settings');

    $isDevMode = ('development' === $settings['mode']);

    if ($isDevMode) {
        $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
    }

    return $bundles;
};

//Mailer
$container['mailer'] = function ($c) {
    $settings = $c->get('settings');

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = $settings['mail']['host'];
    $mail->SMTPAuth = $settings['mail']['auth'];
    $mail->Username = $settings['mail']['username'];
    $mail->From = $settings['mail']['from'];
    $mail->FromName = $settings['mail']['fromname'];
    $mail->Password = $settings['mail']['password'];
    $mail->SMTPSecure = $settings['mail']['secure'];
    $mail->Port = $settings['mail']['port'];
    $mail->isHTML($settings['mail']['is_html']);
    $mail->SMTPOptions = $settings['mail']['smtp_options'];

    $mailer = new \Agora\Modules\Mailer\Mailer(new \Slim\Views\Twig('app/src/Modules/Mailer/Templates/', []), $mail);

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
