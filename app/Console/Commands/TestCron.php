<?php

namespace App\Console\Commands;

use App\Events\SystemMessageEvent;
use App\Http\Controllers\Tourvisor\Service\Ajax;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Mail\SendMails;
use App\Models\CustomerHotTour;
use App\Models\Hotel;
use App\Models\HotelMain;
use App\Models\Tour;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestCron extends Command
{
    /**
     * Тестовый запуск php artisan schedule:run
     *
     * @var string
     */

    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Start cron - test:cron';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        ini_set('memory_limit', '8192M');
        $sendMail =  new SendMails();
        $cron = 'Сработал test:cron в ' .date('d.m.Y H:i:s');

        $sendMail->sendTestSystemMessage($cron);
     //   \Log::info($cron); // в логи
     //   dd($cron);

    }

}
