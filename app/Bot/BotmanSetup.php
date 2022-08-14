<?php

namespace App\Bot;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;

class BotmanSetup
{
    private $config;

    private $cacheDriver;

    public function __construct()
    {
        $this->loadDrivers();
        $this->loadCacheDriver();
    }

    public function getBot()
    {
        return BotManFactory::create($this->config, $this->cacheDriver);
    }

    private function loadDrivers()
    {
        ///////////////////////////////////
        // Here ypu can list the drivers //
        ///////////////////////////////////

        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        // DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);
        
        ////////////////////////////
        // Load the configuration //
        ////////////////////////////

        $this->config = [
            
            // Cache
            'botman' => [
                'conversation_cache_time' => 30
            ],

            // Web driver
            'web' => [
                'matchingData' => [
                    'driver' => 'web',
                ],
            ],
            
            // Messenger Driver (composer require jalexmelendez/botman-messenger-driver)
            /*
            'facebook' => [
                'token' => 'YOUR-FACEBOOK-PAGE-TOKEN-HERE',
                'app_secret' => 'YOUR-FACEBOOK-APP-SECRET-HERE',
                'verification'=>'MY_SECRET_VERIFICATION_TOKEN',
            ],
            */
        ];
    }

    private function loadCacheDriver()
    {
        // By default it uses Laravel cache
        $this->cacheDriver = new LaravelCache();
    }
}