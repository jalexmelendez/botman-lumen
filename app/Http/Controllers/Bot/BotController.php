<?php

namespace App\Http\Controllers\Bot;

use App\Bot\BotmanSetup;
use App\Bot\Conversations\ExampleConversation;
use App\Http\Controllers\Controller;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Facades\BotMan;
use Illuminate\Http\Request;
use UnhandledMatchError;

class BotController extends Controller
{
    protected $botman;

    public function __construct()
    {
        $this->botman = new BotmanSetup();
    }

    /**
     * Calls the bot instance
     * 
     * @param Request $request
     * @return Response
     */
    public function call(Request $request)
    {
        $botman = $this->botman->getBot();

        $botman->hears('{message}', function($botman, $message) {

            try {

                match($message) {

                    'help' => $botman->reply('Say hi to start a conversation'),

                    'hi' => $botman->startConversation(new ExampleConversation()),
                };

            } catch(UnhandledMatchError $e) {
                
                $botman->reply(__('I couldn\'t understand'));

                $botman->reply('Say hi or help');
            }

        });

        $botman->listen();
    }
}