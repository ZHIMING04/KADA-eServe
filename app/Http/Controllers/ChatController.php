<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

class ChatController extends Controller
{
    public function handle()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = [
            // Your configuration
        ];

        $botman = BotManFactory::create($config);

        $botman->hears('{message}', function($botman, $message) {
            if ($message == 'hi' || $message == 'hello' || $message == 'hai') {
                $botman->reply("Hai! Bagaimana saya boleh bantu anda hari ini?");
            } else {
                $botman->reply("Saya terima mesej anda: " . $message);
            }
        });

        $botman->hears('(pejabat|lokasi|alamat)', function($botman) {
            $botman->reply("Pejabat kami terletak di Peti Surat 127, Jalan Dato'Lundang 15710 Kota Bharu, Kelantan.");
        });

        $botman->hears('(waktu|masa|waktu operasi|waktu kerja)', function($botman) {
            $botman->reply("Kami dibuka Isnin hingga Jumaat, 9:00 pagi hingga 5:00 petang");
        });

        $botman->hears('(hubungi|telefon|emel|contact)', function($botman) {
            $botman->reply("Anda boleh menghubungi kami di: \n
            \nTelefon: +609-7455388
            \nEmel: prokada@kada.gov.my");
        });

        $botman->listen();
    }
}
