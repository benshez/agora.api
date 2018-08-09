<?php

/*
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

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Model\SendMessageRequest;

return [

    AgoraApiMailService::class => function (ContainerInterface $container) {
        $adapters = $container->get(AgoraApiSMSGatewayAdapter::class);

        //$token = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

        // $phone_number = '+5531999999999';
        // $message = 'Test smsGatewayV4';
        // $deviceID = 00000;
        // $options = [];

        // $adapters->createContact(
        //     [
        //         'name' => 'Shez',
        //         'phoneNumbers' => ['0466821001'],
        //         'device_id' => '98038'
        //     ]
        // );

        $phone_number = '+61466821001';
        $message = 'Test smsGatewayV4';
        $deviceID = 98038;
        $options = [];

        $adapters->sendMessageToNumber($phone_number, $message, $deviceID, $options);

        //$adapters->createContact('Shez', '+61466821001');
        // $config = Configuration::getDefaultConfiguration();
        // $config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTUzMzM3NTYzNiwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjU4NDQxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.BKw78o-oWibCsF_CQ92naidRnuZy4MRJLQvQ_xLmhII');
        // $apiClient = new ApiClient($config);
        // $messageClient = new MessageApi($apiClient);

        // $sendMessageRequest = new SendMessageRequest([
        //     'phoneNumber' => '+61409330626',
        //     'message' => 'test1',
        //     'deviceId' => 1,
        // ]);

        // $sendMessages = $messageClient->sendMessages([
        //     $sendMessageRequest,
        // ]);
        // // Configure API key authorization: Authorization
        // SMSGatewayMe\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTUzMzM3NTYzNiwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjU4NDQxLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.BKw78o-oWibCsF_CQ92naidRnuZy4MRJLQvQ_xLmhII');
        // // Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
        // // SMSGatewayMe\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'BEARER');

        // $api_instance = new SMSGatewayMe\Client\Api\CallbackApi();
        // $callback = new \SMSGatewayMe\Client\Model\CreateCallbackRequest(); // \SMSGatewayMe\Client\Model\CreateCallbackRequest | callback to create

        return new \PHPMailer(true);
    },

    AgoraApiMessageService::class => function (ContainerInterface $container) {
        return new \GuzzleHttp\Client();
    //return $container->get(AgoraApiMailGunAdapter::class);
    },

    AgoraApiSMSGatewayServiceClient::class => function (ContainerInterface $container) {
        $config = Configuration::getDefaultConfiguration();
        $config->setApiKey('Authorization', $_ENV['SMS_GATEWAY_ME']);

        return new ApiClient($config);
    },

    AgoraApiSMSGatewayAdapter::class => function (ContainerInterface $container) {
        //$container->get(AgoraApiSMSGatewayServiceClient::class)
        $adapters = new \AgoraApi\Application\Core\Adapters\SMSGatewayAdapter(
            $_ENV['SMS_GATEWAY_ME']
        );

        return $adapters;
    },
];
