<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Mail\SendMails;
use App\Models\CustomerHotTour;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;
use Storage;

class UsersTestCron extends Command
{
    /**
     * Тестовый запуск php artisan schedule:run
     *
     * @var string
     */
    protected $signature = 'userstest:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start cron - userstest:cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '8192M');


        $filename = asset(Storage::url('/images/1.txt'));
        $content = file_get_contents($filename);
        $array = json_decode($content);

        $newarray = [];

        foreach ($array as $item) {



                if ($item->email) {
                    $newarray[$item->id]['name'] = $item->username;
                    $newarray[$item->id]['email'] = $item->email;

                    if ($item->phone) {
                        $newarray[$item->id]['phone'] = phone($item->phone);
                    }

                    $flight[] = User::updateOrCreate(
                        ['email' => $newarray[$item->id]['email']],
                        [    'phone' => (isset($newarray[$item->id]['phone']))? $newarray[$item->id]['phone'] :null,
                            'name' => $newarray[$item->id]['name'],
                            'password' => bcrypt(time()),

                        ]
                    );

                }

    }


        dd($newarray);

    }



}
