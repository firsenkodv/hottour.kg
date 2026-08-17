<?php
namespace App\Http\Controllers\Tourvisor\Service;

use App\Models\TourvisorCountry;
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
        $default = json_decode(file_get_contents(__DIR__. '/departure.json'), true);
        foreach($default as $departure){

            if(isset($departure['default'])) {
                return $departure;
            }
        }
        return false;
    }

    public function getDepartureName($id){

        $default = json_decode(file_get_contents(__DIR__. '/departure.json'), true);
        foreach($default as $departure){

            if(($departure['id'] == $id)) {
                return $departure['name'];
            }
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

    public function getDeparture(){
        $query = ['type'=>'departure'];
        $result = $this->_get($query, 'list.php');
        $default = json_decode(file_get_contents(__DIR__. '/departure.json'), true);


        $_d = [];
        foreach($default as $departure){
            $_d[$departure['id']] = $departure;
            if(!empty($_REQUEST['departure']) && !empty($departure['default']) && $_REQUEST['departure'] != $departure['id']){
                $_d[$departure['id']]['default'] = false;
            } elseif (!empty($_REQUEST['departure']) && !empty($departure['default']) && $_REQUEST['departure'] == $departure['id']){
                $_d[$departure['id']]['default'] = true;
                $this->default['departure'] = $departure['id'];
            } elseif (!empty($_REQUEST['departure']) && $_REQUEST['departure'] == $departure['id']){
                $_d[$departure['id']]['default'] = true;
                $this->default['departure'] = $departure['id'];
            } elseif(!empty($departure['default'])){
                $this->default['departure'] = $departure['id'];
            }
        }

        $list = ['popular'=>[], 'other'=>[]];
        foreach($result->lists->departures->departure as $departure){
            if(isset($_d[$departure->id]) && $_d[$departure->id]['active']){
                if($_d[$departure->id]['popular']){
                    $list['popular'][] = $_d[$departure->id];
                } else {
                    $list['other'][] = $_d[$departure->id];
                }

            }
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
