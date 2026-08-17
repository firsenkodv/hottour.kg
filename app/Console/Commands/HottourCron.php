<?php

namespace App\Console\Commands;

use App\Events\SystemMessageEvent;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Mail\SendMails;
use App\Models\CustomerHotTour;
use App\Models\Tour;
use Illuminate\Console\Command;

class HottourCron extends Command
{
    /**
     * Тестовый запуск php artisan schedule:run
     *
     * @var string
     */

    protected $signature = 'hottour:cron';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Start cron - hottour:cron';

    /**
     * Execute the console command.
     */

    public function handle()
    {

        $CustomerHotTour = CustomerHotTour::query()
            ->where('published', true)->get();
        $tour = Tour::query()
            ->where('published', true)->get();
        $api = new Tourvisor();



        foreach ($CustomerHotTour as $item) {
            $city = $item->city;
            $country = $item->country;
            $result_api = ($api->getHotTours($city, $country)) ?: [];





            if (!empty($result_api)) {
                if ((int)$result_api->hottours->hotcount > 0) {
                    $first = current($result_api->hottours->tour);

                    $item->params = $first;

                    $price = round($first->price);
                    $priceold = round($first->priceold);

                    $pr = number_format(($priceold - $price) * 100 / $price);
                    if ($pr == abs($pr)) {
                        $item->procent = $pr; // Число положительное
                    }

                    if ($pr != abs($pr)) {
                        $item->procent = 0; // Число отрицательное
                    }
                    $item->save();
                    \Log::info("Горящие туры - на главной. Страна  - " .  $item->countryname .". Отель добавлен." );  // в логи
                    dump("Горящие туры - на главной. Страна  - " .  $item->countryname .". Отель добавлен." ); // в консоль
                    $mailbody[] = "Горящие туры - на главной. Страна  - " .  $item->countryname .". Отель добавлен."; // в письмо


                } else {
                    $item->params = [];
                    $item->procent = 0;
                    $item->published = 0;
                    $item->save();
                    \Log::info("Горящие туры - на главной. Страна  - " .  $item->countryname .". ОШИБКА -  туров нет hotcount - 0."); // в логи
                    dump("Горящие туры - на главной. Страна  - " .  $item->countryname .". ОШИБКА -  туров нет hotcount - 0." ); // в консоль
                    $mailbody[] = "Горящие туры - на главной. Страна  - " .  $item->countryname .". ОШИБКА -  туров нет hotcount - 0." ; // в письмо
                }


            } else {
                $item->params = [];
                $item->procent = 0;
                $item->published = 0;
                $item->save();
                \Log::info('Горящие туры - на главной. Страна  - ' .  $item->countryname .'. ОШИБКА - $api->getHotTours($city, $country)'); // в логи
                dump('Горящие туры - на главной. Страна  - ' .  $item->countryname .'. ОШИБКА - $api->getHotTours($city, $country)'); // в консоль
                $mailbody[] = 'Горящие туры - на главной. Страна  - ' .  $item->countryname .'. ОШИБКА - $api->getHotTours($city, $country)' ; // в письмо



            }

            sleep(5);

        }


        foreach ($tour as $item) {
            $city = $item->city;
            $country = $item->country;
            $remove = $item->removeitem;

            $result_api = ($api->getHotTours($city, $country)) ?: [];

            if (!empty($result_api)) {
                if ((int)$result_api->hottours->hotcount > 0) {

                    if ($remove) {
                        $result = array_splice($result_api->hottours->tour, $remove);
                        $item->params = $result;

                    } else {
                        $item->params = $result_api->hottours->tour;
                    }
                    $item->save();
                    \Log::info("Страница Туры. Страна  - " .  $item->title .". Туры добавлены." );  // в логи
                    dump("Страница Туры. Страна  - " .  $item->title .". Туры добавлены." ); // в консоль
                    $mailbody[] = "Страница Туры.  Страна  - " .  $item->title .". Туры добавлены."; // в письмо

                } else {
                    $item->params = [];
                    $item->published = 0;
                    $item->save();


                    \Log::info("Страница Туры. Страна  - " .  $item->title .". ОШИБКА -  туров нет hotcount - 0."); // в логи
                    dump("Страница Туры. Страна  - " .  $item->title .". ОШИБКА -  туров нет hotcount - 0." ); // в консоль
                    $mailbody[] = "Страница Туры. Страна  - " .  $item->title .". ОШИБКА -  туров нет hotcount - 0." ; // в письмо



                }
            } else {
                $item->params = [];
                $item->published = 0;
                $item->save();

                \Log::info('Горящие туры - на главной. Страна  - ' .  $item->title .'. ОШИБКА - $api->getHotTours($city, $country)'); // в логи
                dump('Горящие туры - на главной. Страна  - ' .  $item->title .'. ОШИБКА - $api->getHotTours($city, $country)'); // в консоль
                $mailbody[] = 'Горящие туры - на главной. Страна  - ' .  $item->title .'. ОШИБКА - $api->getHotTours($city, $country)' ; // в письмо

            }

            sleep(5);
        }


        /**
         * Событие отправка сообщения админу
         */

        $request = ['commands'=> 'hottour:cron','file_commands'=> 'HottourCron.php','body'=> $mailbody];
        SystemMessageEvent::dispatch($request);

    }
}
