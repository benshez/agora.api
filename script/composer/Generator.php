<?php

namespace Agora\ComposerScript;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

global $argv;

class Generator
{
    
    //private static $servicesDirectory = __DIR__ . "/../../app/src/Services";

    public static function generateService(Event $event)
    {
        print("Generator works well\n");
        echo __DIR__ . "/../../app/src/Services";
    }
}
