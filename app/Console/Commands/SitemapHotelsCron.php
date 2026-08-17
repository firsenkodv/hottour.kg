<?php


namespace App\Console\Commands;
use App\Events\SystemMessageEvent;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\CustomerHotTour;
use App\Models\Hotel;
use App\Models\Tour;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SitemapHotelsCron extends Command
{
    /**
     * Тестовый запуск php artisan schedule:run
     *
     * @var string
     */
    protected $signature = 'sitemap-hotels:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start cron - sitemap-hotels:cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('memory_limit', '8192M');

        if(!Storage::disk('sitemap')->exists('sitemap')) {
            Storage::disk('sitemap')->makeDirectory('sitemap');
            /**
             * создадим если нет директории sitemap
             */

        } else {
            Storage::disk('sitemap')->deleteDirectory('sitemap');
            Storage::disk('sitemap')->makeDirectory('sitemap');
            /**
             * удалим и создадим заново директории sitemap
             */

        }

        $schemas_open = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $url_open = '<url>';
        $loc = '<loc>{s}</loc>';
        $lastmod = '<lastmod>{s}</lastmod>';
        $changefreq = '<changefreq>monthly</changefreq>';
        $priority = '<priority>1.0</priority>';
        $url_close = '</url>';
        $schemas_close = '</urlset>';

        $url_country = config('links.link.countries');

/*        $p = 5000;
          $model = Hotel::all();
          $paginator = ceil(count($model) / $p);*/

        $hotels = Hotel::query()->select('slug', 'hot_category_id', 'updated_at')->where('published', 1)->get();

        foreach($hotels->chunk(5000) as  $y =>$chunk) {
            $data  = $schemas_open;

            foreach ($chunk as $k=>$hotel) {

                if ($hotel->parent->parent) {
                    $url = asset($url_country . '/' . $hotel->parent->parent->slug . '/' . $hotel->parent->slug . '/' . $hotel->slug);


                    $data .= $url_open;
                    $data .= str_replace("{s}", $url, $loc);
                    $data .= str_replace("{s}", $hotel->updated_at->toAtomString(), $lastmod);
                    $data .= $changefreq;
                    $data .= $priority;
                    $data .= $url_close;

                }
            }
            $data .= $schemas_close;

            file_put_contents(Storage::disk('sitemap')->path('sitemap').'/sitemap_'.$y.'.xml', "$data");

            sleep(5);

            dump('Cознан sitemap - ' . env('APP_URL').'/storage/sitemap/sitemap_'.$y.'.xml'); // в консоль
            \Log::info('Cознан sitemap - ' . env('APP_URL').'/storage/sitemap/sitemap_'.$y.'.xml'); // в логи
            $mailbody[] = 'Cознан sitemap - ' . env('APP_URL').'/storage/sitemap/sitemap_'.$y.'.xml'; // в письмо


        }
        /**
         * Событие отправка сообщения админу
         */

        $request = ['commands'=> 'sitemap-hotels:cron','file_commands'=> 'SitemapHotelsCron.php','body'=> $mailbody];
        SystemMessageEvent::dispatch($request);
    }


}
