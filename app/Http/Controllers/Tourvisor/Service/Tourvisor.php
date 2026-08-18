<?php
namespace App\Http\Controllers\Tourvisor\Service;

use App\Models\TourvisorCountry;
use App\Tourvisor\TourvisorSettings;
use Domain\TourvisorCountry\ViewModels\TourvisorCountryViewModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Tourvisor
{
    private $login;
    private $password;
    private $url;
    public $default = [];
    public $last_request = '';

    public function __construct()
    {
        $this->login = (string) config('tourvisor.login');
        $this->password = (string) config('tourvisor.password');
        $this->url = (string) config('tourvisor.url');
    }

    public function _get($query, $script)
    {
        $url = $this->url . $script . "?authlogin=" . $this->login . "&authpass=" . $this->password . "&format=json&" . http_build_query($query, "", "&", PHP_QUERY_RFC1738);
        $this->last_request = $url;

        $result = $this->isListRequest($script)
            ? $this->cachedList($query, $url)
            : (($this->httpGet($url)) ?: null);

        if ($result) {
            return json_decode($result);
        } else {
            return false;
        }
    }

    /**
     * list.php отдаёт справочники (города вылета, страны, регионы, отели) —
     * они меняются раз в сутки, а без кэша каждая загрузка главной страницы
     * это три синхронных HTTP-запроса к tourvisor.ru.
     * Поиск туров (search.php / result.php / hottours.php) не кэшируется.
     */
    private function isListRequest($script): bool
    {
        return $script === 'list.php';
    }

    private function cachedList($query, $url)
    {
        $key = 'tourvisor_list_' . md5(json_encode($query));

        // Ошибку сети не кэшируем: httpGet вернёт false, remember сохранит null
        // и следующий запрос снова сходит в API.
        return Cache::remember($key, (int) config('tourvisor.list_ttl', 21600), function () use ($url) {
            return ($this->httpGet($url)) ?: null;
        });
    }

    public function getDepartureDefault(){
        // город по умолчанию — первый популярный из блока «Города вылета»
        // (админка, при пустой настройке — страновой конфиг)
        $default = TourvisorSettings::departures();
        foreach($default as $departure){
            return $departure;
        }
        return false;
    }

    public function getDepartureName($id){

        // сперва популярные из админки, затем справочник API (кэшируется):
        // в блоке теперь только города своей страны, а кронам и карточкам
        // встречаются и другие id — например, старые записи туров
        $default = TourvisorSettings::departures();
        foreach($default as $departure){

            if(($departure['id'] == $id)) {
                return $departure['name'];
            }
        }

        try {
            $result = $this->_get(['type'=>'departure'], 'list.php');
            foreach($result->lists->departures->departure ?? [] as $departure){
                if($departure->id == $id) {
                    return (string)$departure->name;
                }
            }
        } catch (\Throwable) {
            // сети нет — ведём себя как раньше
        }

        return false;
    }

    public function getCountriesId(){

       //$default = json_decode(file_get_contents(__DIR__. '/countries.json'), true);
        $default = TourvisorCountryViewModel::make()->Countries();



        foreach($default as $departure){

            if(($departure['popular'])) {
                $cuntry_id[$departure['id']] =  $departure['id'];
            }
        }
        return $cuntry_id;
    }

    public function getCountries(){

       //$default = json_decode(file_get_contents(__DIR__. '/countries.json'), true);
        $default = TourvisorCountryViewModel::make()->Countries();

        return $default;
    }

    public function getCountryName($id){

        //$default = json_decode(file_get_contents(__DIR__. '/countries.json'), true);


        $default = TourvisorCountryViewModel::make()->Countries();
        foreach($default as $country){

            if(($country['country_id'] == $id)) {
                return $country['name'];
            }
        }

        return false;
    }

    /**
     * Живой справочник городов вылета API: имя в нижнем регистре ->
     * данные города. Пустой массив — API недоступен и кэша нет.
     * Именно этот список (а не файлы в проекте) решает, какие города
     * доступны учётке; обновляется каждые list_ttl.
     */
    public function departureCatalog(): array
    {
        $result = $this->_get(['type'=>'departure'], 'list.php');
        $api_departures = $result->lists->departures->departure ?? null;

        $catalog = [];
        if (is_iterable($api_departures)) {
            foreach($api_departures as $departure){
                $catalog[mb_strtolower(trim((string)$departure->name))] = [
                    'id' => (string)$departure->id,
                    'name' => (string)$departure->name,
                    'namefrom' => (string)($departure->namefrom ?: $departure->name),
                ];
            }
        }

        return $catalog;
    }

    /**
     * Город сайта -> запись справочника. Сначала точное совпадение имени;
     * имя на сайте и в справочнике может расходиться формой
     * («Караганда» / «Караганды»), поэтому дальше пробуем общую основу
     * без последней буквы — только когда она достаточно длинная и
     * совпадение единственное. null — города в справочнике нет.
     */
    public static function matchDeparture(array $catalog, string $title): ?array
    {
        $key = mb_strtolower(trim($title));
        if ($key === '') {
            return null;
        }
        if (isset($catalog[$key])) {
            return $catalog[$key];
        }

        if (mb_strlen($key) >= 6) {
            $stem = mb_substr($key, 0, -1);
            $found = [];
            foreach ($catalog as $api_name => $data) {
                if (str_starts_with($api_name, $stem)) {
                    $found[] = $data;
                }
            }
            if (count($found) === 1) {
                return $found[0];
            }
        }

        return null;
    }

    public function getDeparture(){
        // «Популярные» (верхняя группа) — блок «Города вылета» в админке
        // (см. TourvisorSettings::departures), порядок строк = порядок в
        // группе, первый — город по умолчанию. «Остальные» подтягиваются
        // автоматически из модели Contact — города, заведённые на сайте, —
        // в порядке их сортировки в админке. Tourvisor-id для них ищется
        // по имени в живом справочнике API; города, которых у Tourvisor
        // нет (Ош, Джалал-Абад...), в селект НЕ попадают: выбор такого
        // города дал бы пустой поиск. Как только Tourvisor добавит город,
        // он появится сам — справочник перечитывается каждые list_ttl,
        // а письмо об этом шлёт крон tourvisor:departures-watch.
        // Сверить руками: php artisan tourvisor:departures
        $catalog = $this->departureCatalog();

        $popular = TourvisorSettings::departures();

        $default_id = $popular[0]['id'] ?? null;
        if(!empty($_REQUEST['departure'])){
            $default_id = $_REQUEST['departure'];
        }
        $this->default['departure'] = $default_id;

        $list = ['popular'=>[], 'other'=>[]];
        $seen = [];

        foreach($popular as $departure){
            $seen[mb_strtolower(trim((string)$departure['name']))] = true;
            $departure['default'] = ($departure['id'] == $default_id);
            $list['popular'][] = $departure;
        }

        $cities = \App\Models\Contact::query()
            ->where('published', 1)
            ->orderBy('sorting')
            ->orderBy('id')
            ->pluck('title');

        foreach($cities as $title){
            $title = trim((string)$title);
            $key = mb_strtolower($title);
            if($title === '' || isset($seen[$key])){
                continue; // популярный или дубль города в контактах
            }
            $seen[$key] = true;

            $api = self::matchDeparture($catalog, $title);
            if ($api === null) {
                continue; // города нет в справочнике Tourvisor — не выводим
            }
            $list['other'][] = [
                'id' => $api['id'],
                'name' => $title,
                'namefrom' => $api['namefrom'],
                'default' => ($api['id'] == $default_id),
            ];
        }

        return $list;
    }

    public function getCountry($dep = false){
        if($dep === false) {

            $dep = ($this->default)?$this->default['departure']:[];
        }
        //$default = json_decode(file_get_contents(__DIR__.'/countries.json'), true);
        $default = TourvisorCountryViewModel::make()->Countries();
        $_d = [];


        foreach($default as $country) {

            $_d[$country['country_id']] = $country;
            if(!empty($_REQUEST['country']) && !empty($country['default']) && $_REQUEST['country'] != $country['country_id']){

                $_d[$country['country_id']]['default'] = false;

            } elseif (!empty($_REQUEST['country']) && !empty($country['default']) && $_REQUEST['country'] == $country['country_id']){
                $_d[$country['country_id']]['default'] = true;
                $this->default['country'] = $country['country_id'];
            } elseif (!empty($_REQUEST['country']) && $_REQUEST['country'] == $country['country_id']){
                $_d[$country['country_id']]['default'] = true;
                $this->default['country'] = $country['country_id'];
            } elseif(!empty($country['default'])){
                $this->default['country'] = $country['country_id'];
            }

        }

        $query = ['type'=>'country'];
        if($dep){
            if(is_array($dep)) {
                $query['cndep'] = implode(",", $dep);
            }
            else {
                $query['cndep'] = $dep;
            }
        }

        $result = $this->_get($query, 'list.php');
        $tourv_countries = $result->lists->countries->country;



        $list = ['popular'=>[], 'other'=>[]];

        foreach ($default as $k => $c)
        {
            foreach ($tourv_countries as $country) {


                if($c['country_id'] == (int)$country->id) {

                    if(isset($_d[$country->id]) && $_d[$country->id]['active']){

                        if($_d[$country->id]['popular']){
                            $list['popular'][] = $_d[$country->id];
                        } else {
                            $list['other'][] = $_d[$country->id];
                        }
                    }

                }

            }

        }


        return $list;
    }

    public function getRegions($country = false){

        if(!$country){
            $country = $this->default['country'];
        }
        $query = ['type'=>'region', 'regcountry' => $country];

        $result = $this->_get($query, 'list.php');
        return $result;

    }

    public function getHotels($country = false, $regions = false, $addparams = []){
        if(!$country){
            $country = $this->default['country'];
        }
        $query = ['type'=>'hotel', 'hotcountry' => $country];
        if($regions){
            if(is_array($regions)) {
                $query['cndep'] = implode(",", $regions);
            }
            else {
                $query['hotregion'] = $regions;
            }
        }
        if($addparams){
            foreach($addparams as $key => $value){
                if(is_array($value)) {
                    $query[$key] = implode(",", $value);
                }
                else {
                    $query[$key] = $value;
                }
            }
        }
        $result = $this->_get($query, 'list.php');
        return $result;

    }

    public function getFlag($name){
        $name = str_replace(" ", '_', mb_strtolower($name));
        $simbol = ['а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','щ','ш','ъ','ь','э','ю','я','ы'];
        $repeat = ['a','b','v','g','d','e','z','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','c','c','s','','','e','u','i','y'];
        return str_replace($simbol, $repeat, $name);
    }

    /**
     * Горячие туры
     */
    public function getHotTours($city, $country)
    {
        $query = ['city'=> $city, 'items' => '100', 'sort' => 1, 'countries' => $country , 'picturetype' => 1, 'currency' => 3];
        $result = $this->_get($query, 'hottours.php');
        return $result;

    }
    /**
     * Для корнсольной команды tourvisorhotel
     */
    public function _getHotel($query, $script)
    {
        $url = $this->url . $script . "?authlogin=" . $this->login . "&authpass=" . $this->password . "&" . $query;

        $result = ($this->httpGet($url))?:null;
        if($result) {
            return json_decode($result);
        }
        return null;
    }

    public function getHotel($id)
    {
        $url = $this->url . 'hotel.php?format=json&hotelcode=' . $id . '&imgbig=1&authlogin=' . $this->login . '&authpass=' . $this->password;
        $result = ($this->httpGet($url))?:null;
        if($result) {
            return json_decode($result);
        }
        return null;
    }
    /**
     * Для корнсольной команды tourvisorhotel
     */
    /**
     * Для корнсольной команды mainhotels
     */
    public function getRequestid($params, $script = 'search.php')
    {
        /**
         * date 7 days +
         */
        $time7 = strtotime('+7 days', time());
        $d7 =  date('d.m.Y', $time7);
        $time1 = strtotime('+1 days', time());
        $d1 =  date('d.m.Y', $time1);


        $url = $this->url . $script . "?authlogin=" . $this->login . "&authpass=" . $this->password . "&format=json&departure=".$params['departure'] ."&country=". $params['country_id'] ."&hotels=". $params['id'] ."&nightsfrom=6&nightsto=12&adults=".$params['adults']."&currency=3&action=searchTour&regions=".$params['region_id']."&datefrom=".$d1."&dateto=".$d7."&priceto=10000000&pricefrom=0&child=". $params['child'];

        $result = $this->httpGet($url);
        return json_decode($result);

    }

    public function getToursForHotel($requestid, $script = 'result.php')
    {

        $url = $this->url . $script . "?authlogin=" . $this->login . "&authpass=" . $this->password . "&format=json&requestid=". $requestid ."&type=result";

             $result = $this->httpGet($url);
            return json_decode($result);


    }
    /**
     * Для корнсольной команды mainhotels
     */

    /**
     * Единая точка сетевых запросов к API.
     * Режим задаётся в config/tourvisor.php: live | record | replay | auto
     */
    private function httpGet($url)
    {
        $mode = config('tourvisor.mode', 'live');

        if ($mode === 'live') {
            return $this->fetch($url);
        }

        $path = $this->cachePath($url);

        if ($mode === 'replay') {
            return is_file($path) ? file_get_contents($path) : false;
        }

        if ($mode === 'auto' && is_file($path)) {
            return file_get_contents($path);
        }

        $result = $this->fetch($url);

        if ($result !== false) {
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            file_put_contents($path, $result);
        }

        return $result;
    }

    /**
     * Запрос в сеть с таймаутом: без него недоступный tourvisor.ru вешал
     * страницу на default_socket_timeout (60 секунд).
     */
    private function fetch($url)
    {
        $context = stream_context_create([
            'http' => [
                'timeout' => (float) config('tourvisor.timeout', 8),
            ],
        ]);

        $result = @file_get_contents($url, false, $context);

        if ($result === false) {
            Log::warning('Tourvisor: запрос не выполнен', ['url' => $this->maskUrl($url)]);
        }

        return $result;
    }

    /** Убирает логин и пароль из URL перед записью в лог. */
    private function maskUrl($url): string
    {
        return str_replace([$this->login, $this->password], '***', $url);
    }

    /**
     * Путь к файлу кэша. Ключ считается по адресу без параметров,
     * перечисленных в tourvisor.ignore_params
     */
    private function cachePath($url)
    {
        $parts = parse_url($url);
        parse_str(isset($parts['query']) ? $parts['query'] : '', $query);

        foreach (config('tourvisor.ignore_params', []) as $param) {
            unset($query[$param]);
        }

        ksort($query);

        $key = sha1($parts['path'] . '?' . http_build_query($query));

        $dir = config('tourvisor.cache_path') ?: storage_path('app/tourvisor-cache');

        return $dir . DIRECTORY_SEPARATOR . $key . '.json';
    }
}
