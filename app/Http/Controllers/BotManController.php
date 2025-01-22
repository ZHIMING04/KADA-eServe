<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {
            if ($message == 'hi' || $message == 'hello') {
                $botman->reply("Salam! Bagaimana saya boleh bantu anda?");
            } else {
                $botman->reply("Sila tanya soalan anda.");
            }
        });

        $botman->listen();
    }
} 