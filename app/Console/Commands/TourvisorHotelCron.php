<?php

namespace App\Console\Commands;

use App\Events\SystemMessageEvent;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Mail\SendMails;
use App\Models\CustomerHotTour;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Tour;
use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;

class TourvisorHotelCron extends Command
{
    /**
     * Тестовый запуск php artisan schedule:run
     *
     * @var string
     */
    protected $signature = 'tourvisorhotel:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start cron - tourvisorhotel:cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '8192M');

        $t = new Tourvisor();
        $t_getCountries = [];
        $t_getCountries = $t->getCountries(); // это страны из таблицы tourvisor_counrties
        if (count($t_getCountries)) {
            foreach ($t_getCountries as $country) {
                $hot_category_id = $country['hot_category_id'];
                $country_id = $country['country_id'];


                //  echo ' $country_id = ' . $country_id. ' |  $hot_category_id = ' .$hot_category_id; exit;

                $script = 'list.php';
                $query = 'type=hotel&hotcountry=' . $country_id;
                $result = $t->_getHotel($query, $script);
                if ($result) {
                    $all = [];
                    $r = $result->lists->hotels->hotel;
                    $array = [];
                    foreach ($r as $k => $item) {
                        $hotel = $t->getHotel($item->id);
                        //  dd($hotel);


                        if ($hotel) {
                            /** если есть результат по отелю **/
                            if ($hotel->data->hotel->countrycode) {
                                $images = '';
                                $site_img = '';
                                $metatitle = '';
                                $description = '';
                                $array[$k]['title'] = strip_tags(ucfirst(strtolower($hotel->data->hotel->name)));
                                $array[$k]['slug'] = $item->id;


                                $array[$k]['territory'] = (isset($hotel->data->hotel->territory)) ? $hotel->data->hotel->territory : '';
                                $array[$k]['inroom'] = (isset($hotel->data->hotel->inroom)) ? $hotel->data->hotel->inroom : '';
                                $array[$k]['roomtypes'] = (isset($hotel->data->hotel->roomtypes)) ? $hotel->data->hotel->roomtypes : '';
                                $array[$k]['beach'] = (isset($hotel->data->hotel->beach)) ? $hotel->data->hotel->beach : '';
                                $array[$k]['servicefree'] = (isset($hotel->data->hotel->servicefree)) ? $hotel->data->hotel->servicefree : '';
                                $array[$k]['servicepay'] = (isset($hotel->data->hotel->servicepay)) ? $hotel->data->hotel->servicepay : '';
                                $array[$k]['animation'] = (isset($hotel->data->hotel->animation)) ? $hotel->data->hotel->animation : '';
                                $array[$k]['child'] = (isset($hotel->data->hotel->child)) ? $hotel->data->hotel->child : '';
                                $array[$k]['meallist'] = (isset($hotel->data->hotel->meallist)) ? $hotel->data->hotel->meallist : '';
                                $array[$k]['square'] = (isset($hotel->data->hotel->square)) ? $hotel->data->hotel->square : '';


                                $array[$k]['hot_category_id'] = $hot_category_id;
                                $array[$k]['country_id'] = ($hotel->data->hotel->countrycode) ?: '';
                                $array[$k]['region_id'] = ($hotel->data->hotel->regioncode) ?: '';
                                $array[$k]['region'] = strip_tags($hotel->data->hotel->region);
                                $array[$k]['stars'] = ($hotel->data->hotel->stars) ?: '';
                                $array[$k]['rating'] = ($hotel->data->hotel->rating) ?: '';
                                $array[$k]['placement'] = (isset($hotel->data->hotel->placement)) ? strip_tags(ucfirst($hotel->data->hotel->placement)) : '';
                                $array[$k]['desc'] = (isset($hotel->data->hotel->description)) ? strip_tags(ucfirst($hotel->data->hotel->description)) : '';

                                $array[$k]['imagescount'] = ($hotel->data->hotel->imagescount) ?: 0;

                                if (isset($hotel->data->hotel->images->image)) {
                                    $images = '[';
                                    foreach ($hotel->data->hotel->images->image as $img) {
                                        if ($img == end($hotel->data->hotel->images->image)) {
                                            $images .= '"' . $img . '"';
                                        } else {
                                            $images .= '"' . $img . '",';
                                        }
                                    }
                                    $images .= ']';
                                }

                                $array[$k]['params'] = ($images) ?: '';
                                $params = ($array[$k]['imagescount']) ? $hotel->data->hotel->images->image : null;


                                $array[$k]['build'] = (isset($hotel->data->hotel->build)) ? strip_tags(ucfirst(strtolower($hotel->data->hotel->build))) : '';
                                $array[$k]['repair'] = (isset($hotel->data->hotel->repair)) ? strip_tags(ucfirst(strtolower($hotel->data->hotel->repair))) : '';
                                $array[$k]['coord'] = ($hotel->data->hotel->coord1 and $hotel->data->hotel->coord2) ? $hotel->data->hotel->coord1 . ',' . $hotel->data->hotel->coord2 : '';
                                $metatitle = strip_tags(ucfirst(strtolower($hotel->data->hotel->name)));
                                if (isset($hotel->data->hotel->country)) {
                                    $metatitle .= ' | ' . $hotel->data->hotel->country;
                                }
                                if (isset($hotel->data->hotel->region)) {
                                    $metatitle .= ' | ' . $hotel->data->hotel->region;
                                }
                                if (isset($hotel->data->hotel->stars)) {
                                    $metatitle .= ' | звезд ' . $hotel->data->hotel->stars;
                                }
                                if (isset($hotel->data->hotel->rating)) {
                                    $metatitle .= ' | рейтинг ' . $hotel->data->hotel->rating;
                                }
                                $array[$k]['metatitle'] = ($metatitle) ?: '';

                                if (isset($hotel->data->hotel->placement)) {
                                    $description = strip_tags($hotel->data->hotel->placement);
                                } else {
                                    $description .= 'Hotel ' . strip_tags(ucfirst(strtolower($hotel->data->hotel->name))) . ', ' . $hotel->data->hotel->country . ', звёздность ' . $hotel->data->hotel->stars;
                                    if (isset($hotel->data->hotel->build)) {
                                        $description .= ', построен в ' . strip_tags($hotel->data->hotel->build);
                                    }
                                    if (isset($hotel->data->hotel->repair)) {
                                        $description .= ', прошел реконструкцию  ' . strip_tags($hotel->data->hotel->repair);
                                    }
                                    if (isset($hotel->data->hotel->rating)) {
                                        $description .= ', имеет рейтинг ' . $hotel->data->hotel->rating;
                                    }
                                }

                                $array[$k]['description'] = ($description) ?: '';
                                $array[$k]['keywords'] = 'id объекта ' . $item->id . ', ' . strip_tags($hotel->data->hotel->name) . ', ' . $hotel->data->hotel->country . ', ' . $hotel->data->hotel->region;


                                Hotel::updateOrCreate(['slug' => $array[$k]['slug']],
                                    [
                                        'title' => $array[$k]['title'],
                                        'slug' => $array[$k]['slug'],
                                        'hot_category_id' => $array[$k]['hot_category_id'],
                                        'territory' => $array[$k]['territory'],
                                        'inroom' => $array[$k]['inroom'],
                                        'roomtypes' => $array[$k]['roomtypes'],
                                        'beach' => $array[$k]['beach'],
                                        'servicefree' => $array[$k]['servicefree'],
                                        'servicepay' => $array[$k]['servicepay'],
                                        'animation' => $array[$k]['animation'],
                                        'child' => $array[$k]['child'],
                                        'meallist' => $array[$k]['meallist'],
                                        'square' => $array[$k]['square'],
                                        'country_id' => ($array[$k]['country_id']) ?: null,
                                        'region_id' => ($array[$k]['region_id']) ?: null,
                                        'region' => ($array[$k]['region']) ?: '',
                                        'stars' => ($array[$k]['stars']) ?: null,
                                        'rating' => ($array[$k]['rating']) ?: null,
                                        'placement' => ($array[$k]['placement']) ?: '',
                                        'desc' => ($array[$k]['desc']) ?: '',
                                        'imagescount' => $array[$k]['imagescount'],
                                        'params' => $params,
                                        'build' => ($array[$k]['build']) ?: '',
                                        'coord' => ($array[$k]['coord']) ?: '',
                                        'metatitle' => ($array[$k]['metatitle']) ?: '',
                                        'description' => ($array[$k]['description']) ?: '',
                                        'keywords' => ($array[$k]['keywords']) ?: '',
                                    ]);

                            }
                        }

                    }

 /*                   $list = collect($array);
                    (new FastExcel($list))->export('storage/app/public/excel/' . $country_id . '.xlsx');*/

                    dump("Обработана страна - " . $country['name']); // в консоль
                    \Log::info("Обработана страна - " . $country['name']); // в логи
                    $mailbody[] = "Обработана страна - " . $country['name']; // в письмо
                } else {

                    dump("Cтрана не обнаружена - " . $country['name']); // в консоль
                    \Log::info("Cтрана не обнаружена  - " . $country['name']); // в логи
                    $mailbody[] = "Cтрана не обнаружена  - " . $country['name']; // в письмо

                }

            } // forteach
        } // if

        /**
         * Событие отправка сообщения админу
         */
        $request = ['commands' => 'tourvisorhotel:cron', 'file_commands' => 'TourvisorHotelCron.php', 'body' => $mailbody];
        SystemMessageEvent::dispatch($request);

    }

}
