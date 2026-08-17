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

class MainHotelsCron extends Command
{
    /**
     * Тестовый запуск php artisan schedule:run
     *
     * @var string
     */

    protected $signature = 'mainhotels:cron';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Start cron - mainhotels:cron';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        ini_set('memory_limit', '8192M');

        $api = new Tourvisor();

        $hotels = Hotel::query()
            ->where('published', 1)
            ->where('index', 1)
            ->take(20)
            ->get();



        if ($hotels->count() > 6) {

            HotelMain::truncate();

            foreach ($hotels as $hotel) {


                settype($h, "array");

                $departure = ['code' => $hotel->city, 'city' => getDepartureName($hotel->city)]; // город вылета выставляется в админке Model Hotel
                $adults = ['adults' => 2, 'child' => 0]; // взрослые и дети

                $result = $api->getHotel($hotel->slug);

                if($result) { /** если есть результат по отелю **/
                    $params = ['region_id' => $hotel->region_id, 'id' => $hotel->slug, 'country_id' => $hotel->country_id, 'departure' => $departure['code'], 'adults' => $adults['adults'], 'child' => $adults['child'],];

                    $api = new Tourvisor();
                    $r = $api->getRequestid($params);

                    $requestid = $r->result->requestid;

                    for ($i = 1; $i < 6; $i++) {

                        $res = $api->getToursForHotel($requestid);

                        if ($res->data->status->progress == 100) {

                            dump('Сработало - 100%');
                            \Log::info('Сработало - 100%'); // в логи

                            break;

                        }
                        sleep(10);
                        dump('Попытка - ' . $i);
                        \Log::info('Попытка - ' . $i); // в логи


                    }


                    if ($res->data->status->toursfound != 0) {


                        $h['slug'] = $hotel->slug;
                        $h['name'] = $result->data->hotel->name;
                        $h['img'] = $result->data->hotel->images->image[0];
                        $h['star'] = $result->data->hotel->stars;
                        $h['country'] = $result->data->hotel->country;


                        $h['price'] = ($res->data->result->hotel[0]->tours->tour[0]->price) ?: '';
                        $h['meal'] = ($res->data->result->hotel[0]->tours->tour[0]->meal) ?: '';
                        $h['mealrussian'] = ($res->data->result->hotel[0]->tours->tour[0]->mealrussian) ?: '';
                        $h['placement'] = ($res->data->result->hotel[0]->tours->tour[0]->placement) ?: '';
                        $h['room'] = ($res->data->result->hotel[0]->tours->tour[0]->room) ?: '';
                        $h['nights'] = ($res->data->result->hotel[0]->tours->tour[0]->nights) ?: '';
                        $h['flydate'] = ($res->data->result->hotel[0]->tours->tour[0]->flydate) ?: '';
                        $h['city'] = ($departure['city']) ?: '';
                        $h['adults'] = ($adults['adults']) ?: '';
                        $h['child'] = ($adults['child']) ?: '';


                        HotelMain::query()->create([
                            'title' => $h['name'],
                            'slug' => $h['slug'],
                            'img' => $h['img'],
                            'star' => $h['star'],
                            'country' => $h['country'],
                            'price' => $h['price'],
                            'meal' => $h['meal'],
                            'placement' => $h['placement'],
                            'mealrussian' => $h['mealrussian'],
                            'room' => $h['room'],
                            'nights' => $h['nights'],
                            'flydate' => $h['flydate'],
                            'city' => $h['city'],
                            'adults' => $h['adults'],
                            'child' => $h['child'],
                        ]);

                        dump("Загружен отель  - " . $h['name']); // в консоль
                        \Log::info("Загружен отель  - " . $h['name']); // в логи
                        $mailbody[] = "Загружен отель  - " . $h['name']; // в письмо
                    } else {
                        dump("Нет туров"); // в консоль
                        \Log::info("Нет туров"); // в логи
                        $mailbody[] = "Нет туров"; // в письмо
                    }
                }

                sleep(10);

            }

            /**
             * Событие отправка сообщения админу
             */

            $request = ['commands'=> 'mainhotels:cron','file_commands'=> 'MainHotelsCron.php','body'=> $mailbody];
            SystemMessageEvent::dispatch($request);



        }


    }

}
