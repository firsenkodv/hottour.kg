<?php

use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Support\Flash\Flash;
use Support\Module\Module;
use Illuminate\Support\Facades\Route;


if (!function_exists('flash')) {

    function flash(): Flash
    {
        return app(Flash::class);
    }
}
/* вырезаем из телефона все, кроме цифр */
if (!function_exists('phone')) {
    function phone(string $phone = null): string|int
    {
        return trim(preg_replace('/^1|\D/', "", $phone));
    }
}


/* Формируем slug  Версия 2 */
if (!function_exists('createSlug')) {
    function createSlug($title, $model)
    {
        $slug = Str::slug($title, '-');
        $count = $model::query()->where('slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }
}

/* Формируем slug Версия 1  */
if (!function_exists('slugCheck')) {

    function slugCheck($str, Model $model)
    {
        $placeObj = $model;

        $businessName = $str; //Input from User
        $businessNameURL = Str::slug($businessName, '-'); //Convert Input to Str Slug

        //Check if this Slug already exists
        $checkSlug = $placeObj->whereSlug($businessNameURL)->exists();

        if ($checkSlug) {
            //Slug уже существует.
            //Добавьте числовой префикс в конце. Начиная с 1
            $numericalPrefix = 1;

            while (1) {
                //Check if Slug with final prefix exists.

                $newSlug = $businessNameURL . "-" . $numericalPrefix++; //new Slug with incremented Slug Numerical Prefix
                $newSlug = Str::slug($newSlug); //String Slug


                $checkSlug = $placeObj->whereSlug($newSlug)->exists(); //Check if already exists in DB
                //This returns true if exists.

                if (!$checkSlug) {

                    //There is not more coincidence. Finally found unique slug.
                    $slug = $newSlug; //New Slug

                    break; //Break Loop

                }


            }

        } else {
            //Slug do not exists. Just use the selected Slug.
            $slug = $businessNameURL;
        }

        return $slug;
    }


}


if (!function_exists('format_phone')) {

    function format_phone($from): string
    {
        if ($from) {
            $to = sprintf("%s (%s) %s-%s-%s",
                substr($from, 0, 1),
                substr($from, 1, 3),
                substr($from, 4, 3),
                substr($from, 7, 2),
                substr($from, 9)
            );
            return '+' . $to;
        }
        return '';
    }
}


if (!function_exists('manager_reserve')) {

    function manager_reserve()
    {
        return User::query()->whereNotNull('manager_reserve')->first();

    }
}


if (!function_exists('birthdate')) {

    function birthdate($birthdate, $integer = null): string
    {
        if ($birthdate) {

            $birthday = new DateTime($birthdate);
            $interval = $birthday->diff(new DateTime);
            $int = $interval->y;
            if ($integer) {
                return (int)$int; // сокращенный вариант
            }
            $date = new DateTime($birthdate);
            $formattedDate = $date->format('d.m.Y');
            return $formattedDate . ' (' . $int . ')';


        }
        return '';
    }
}

if (!function_exists('rusbirthdate')) {

    function rusbirthdate($birthdate): string
    {
        if ($birthdate) {

            $birthday = new DateTime($birthdate);
            $interval = $birthday->diff(new DateTime);
            $int = $interval->y;
            $date = new DateTime($birthdate);
            $formattedDate = $date->format('d.m.Y');
            return $formattedDate;


        }
        return '';
    }
}


if (!function_exists('sity')) {

    function sity($value): string
    {
        foreach (config('selects.data_sity') as $k => $v) {
            if ($value == $k) {
                return $v['text'];
            }
        }
        return $value;
    }
}


if (!function_exists('clearFolder')) {

    function clearFolder($path, $disk)
    {

        if (Storage::disk($disk)->directoryExists($path)) {

            $folderPath = public_path('storage/' . $disk . '/' . $path);

            File::deleteDirectory($folderPath);

            return __('Папка успешно очищена и удалена.');

        }
        return __('Папка не существует, файлов не было удалено.');


    }
}


if (!function_exists('module')) {

    function module(): Module
    {
        return app(Module::class);
    }
}

if (!function_exists('role')) {

    function role($id = null): string
    {
        if (!auth()->user()) {
            return 'guest';
        }

        if ($id) {

            $user = User::query()
                ->where('id', $id)
                ->first();
            if ($user) {
                if (isset($user->parent)) {
                    if (strtolower($user->parent->name) == 'admin') {
                        return 'admin';
                    }
                }

                if ($user->senior == $user->id) {
                    return 'senior';
                }


                if (isset($user->parent)) {
                    if (strtolower($user->parent->name) == 'manager') {
                        return 'manager';
                    }
                }


                return 'user';
            }
            return 'error_id';

        }
        $id = (auth()->user()) ? auth()->user()->id : '';
        if ($id) {

            $user = User::query()
                ->where('id', $id)
                ->first();
            if ($user) {
                if (isset($user->parent)) {
                    if (strtolower($user->parent->name) == 'admin') {
                        return 'admin';
                    }
                }
                if (isset($user->parent)) {
                    if (strtolower($user->parent->name) == 'manager') {
                        return 'manager';
                    }
                }
                return 'user';
            }
        }
        return 'error_id';

    }
}


if (!function_exists('num2word')) {

    function num2word($num, $words)
    {
        $num = $num % 100;
        if ($num > 19) {
            $num = $num % 10;
        }
        switch ($num) {
            case 1:
            {
                return ($words[0]);
            }
            case 2:
            case 3:
            case 4:
            {
                return ($words[1]);
            }
            default:
            {
                return ($words[2]);
            }
        }
    }


}


if (!function_exists('ext')) {

    function ext($ext): string
    {
        switch (mb_strtolower($ext)) {
            case 'jpg':
                $result = '/images/files/jpg.svg';
                break;
            case 'jpeg':
                $result = '/images/files/jpg.svg';
                break;
            case 'doc':
                $result = '/images/files/doc.svg';
                break;
            case 'docx':
                $result = '/images/files/doc.svg';
                break;
            case 'png':
                $result = '/images/files/jpg.svg';
                break;
            case 'txt':
                $result = '/images/files/txt.svg';
                break;
            case 'zip':
                $result = '/images/files/zip.svg';
                break;
            case 'rar':
                $result = '/images/files/zip.svg';
                break;
            case 'pdf':
                $result = '/images/files/pdf.svg';
                break;
            default:
                $result = '/images/files/zip.svg';

        }
        return $result;
    }
}

if (!function_exists('active_link')) {
    function active_link(string|array $names, string $class = 'active'): string|null
    {

        if (is_string($names)) {
            $names = [$names];
        }
        return Route::is($names) ? $class : null;
    }
}

if (!function_exists('active_linkMenu')) {
    function active_linkMenu($url, string $find = null, string $class = 'active'): string|null
    {


        if ($find) {

            if (str_starts_with(url()->current(), trim($url))) {
                return $class;
            }
            return null;

        }


        return ($url == url()->current()) ? $class : null;
    }
}

if (!function_exists('route_name')) {
    function route_name(): string|null
    {

        return Route::currentRouteName();
    }
}

if (!function_exists('shortcode')) {
    function shortcode($html)
    {
        preg_match_all("/\{(.+?)\}/", $html, $matches);
        if ($matches[1]) {
            foreach ($matches[1] as $match) {
                //dd($match);
                $html = str_replace('{' . $match . '}', '<embed style="width: 100%" width="100%" height="480" src="https://www.youtube.com/embed/' . $match . '" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></embed>', $html);
            }
            //  return implode(',', $matches[1]);
            return $html;
        }
        return $html;
    }
}

if (!function_exists('rusdate')) {
    function rusdate($timestump): string|null
    {
        $month = [1 => "Янв", 2 => "Фев", 3 => "Мар", 4 => "Апр", 5 => "Май", 6 => "Июн", 7 => "Июл", 8 => "Авг", 9 => "Сен", 10 => "Окт", 11 => "Ноя", 12 => "Дек"];
        $return = date('d', $timestump);
        $return .= " " . $month[date('n', $timestump)];

        return $return;
    }
}

if (!function_exists('rusdate2')) {
    function rusdate2($date): string|null
    {
        $timestump = strtotime($date);
        $month = [1 => "янв.", 2 => "фев.", 3 => "мар.", 4 => "апр.", 5 => "май", 6 => "июн.", 7 => "июл.", 8 => "авг.", 9 => "сен.", 10 => "окт.", 11 => "ноя.", 12 => "дек."];

        $days = ['(вс)', '(пн)', '(вт)', '(ср)', '(чт)', '(пт)', '(сб)'];

        $day = $days[date("w", strtotime($date))];
        $m = $month[date('n', $timestump)];
        $d = date('d', $timestump);

        return $d . ' ' . $m . ' ' . $day;

    }
}

if (!function_exists('rusdate3')) {
    function rusdate3($date): string|null
    {
        $timestump = strtotime($date);
        $month = [1 => "января", 2 => "февраля", 3 => "марта", 4 => "апреля", 5 => "мая", 6 => "июня", 7 => "июля", 8 => "августа", 9 => "сентября", 10 => "октября", 11 => "ноября", 12 => "декабря"];

        $days = ['(вс)', '(пн)', '(вт)', '(ср)', '(чт)', '(пт)', '(сб)'];

        $day = $days[date("w", strtotime($date))];
        $m = $month[date('n', $timestump)];
        $y = date('Y', $timestump);
        $d = date('d', $timestump);

        return $d . ' ' . $m . ' ' . $y . ' г.';

    }
}
if (!function_exists('rusdate4')) {
    function rusdate4($date): string|null
    {
        $timestump = strtotime($date);
        $month = [1 => "янв.", 2 => "фев.", 3 => "мар.", 4 => "апр.", 5 => "май", 6 => "июн.", 7 => "июл.", 8 => "авг.", 9 => "сен.", 10 => "окт.", 11 => "ноя.", 12 => "дек."];


        $days = ['(вс)', '(пн)', '(вт)', '(ср)', '(чт)', '(пт)', '(сб)'];

        $day = $days[date("w", strtotime($date))];
        $m = $month[date('n', $timestump)];
        $his =  '('.date('H:i:s', $timestump).')';
        $y = date('Y', $timestump);
        $d = date('d', $timestump);

        return $d . '  ' . $m . ' '. $his .' '. $day.' ' . $y . ' г.';

    }
}

if (!function_exists('departureCode')) {
    function departureCode(): string|int
    {
        $toutvisor = new Tourvisor();
        return $toutvisor->getDepartureDefault()['id'];
    }
}

if (!function_exists('getDepartureName')) {
    function getDepartureName($id): string|int
    {
        $toutvisor = new Tourvisor();
        return $toutvisor->getDepartureName($id);
    }
}

if (!function_exists('getCountryName')) {
    function getCountryName($id): string|int
    {
        $toutvisor = new Tourvisor();
        return $toutvisor->getCountryName($id);
    }
}

if (!function_exists('getCountriesId')) {
    function getCountriesId(): array
    {
        $toutvisor = new Tourvisor();
        return $toutvisor->getCountriesId();
    }
}

if (!function_exists('departureSity')) {
    function departureSity(): string|int
    {
        $toutvisor = new Tourvisor();
        return $toutvisor->getDepartureDefault()['name'];
    }
}

if (!function_exists('countries')) {
    function countries()
    {
        $toutvisor = new Tourvisor();
        return $toutvisor->getCountry();
    }
}

if (!function_exists('departure')) {
    function departure()
    {
        $toutvisor = new Tourvisor();
        return $toutvisor->getDeparture();
    }
}
if (!function_exists('currency')) {
    function currency($cur)
    {
        foreach (config('currency.currency') as $k => $currency) {
            if ($k == $cur) {
                return $currency;
            }
        }
        return '';
    }
}

/**
 *  цифры
 */
if (!function_exists('price')) {
    function price($price)
    {
        $price = (int)$price;
        if (is_int($price)) {
            return number_format($price, 0, '.', ' ');
        }
        return $price;
    }
}

/**
 *  цифры
 */
if (!function_exists('price_reverse')) {
    function price_reverse($price)
    {
        if ($price) {
            return (int)filter_var($price, FILTER_SANITIZE_NUMBER_INT);
        }


        return $price;
    }
}

if (!function_exists('cart')) {
    function cart()
    {
        if (auth()->user()) {
            if (role(auth()->user()->id) == "admin" or role(auth()->user()->id) == "senior" or role(auth()->user()->id) == "manager") {
                return true;
            }
        }
        return false;
    }
}


if (!function_exists('favorite_user')) {
    function favorite_user()
    {
        if (auth()->user()) {
            if (role(auth()->user()->id) == "user") {
                return true;
            }
        }
        return false;
    }
}


if (!function_exists('intervention')) {
    /**
     * Миниатюра изображения с кэшированием в storage.
     *
     * Intervention Image v4: чтение файла — decode(), а fit() из v2
     * называется cover().
     *
     * $method — имя из времён Intervention Image v2 ('fit|resize|crop'):
     * оно участвует в пути кэша, поэтому имена сохранены, а на методы v4
     * переводятся через $methods ниже. Иначе все уже сгенерированные
     * миниатюры в storage/app/public/{раздел}/fit/{размер} пришлось бы
     * создавать заново.
     */
    function intervention(string $size, string $image = null, string $dir = 'countries', string $method = 'fit')
    {
        if (!$image) {
            return null;
        }

        $storage = Storage::disk('intervention');

        if (!$storage->exists($image)) {
            return null;
        }

        $file = File::basename($image);

        abort_if(!in_array($size, config('thumbnail.allowed_sizes', [])),
            403,
            'size not allowed'
        );

        // v2 → v4: fit кадрировал по центру с сохранением пропорций — это cover
        $methods = [
            'fit' => 'cover',
            'resize' => 'resize',
            'crop' => 'crop',
        ];
        $call = $methods[$method] ?? 'cover';

        $realPath = $image;
        $newDirPath = "$dir/$method/$size";
        $resultPaht = "$newDirPath/$file";

        if (!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }


        if (!$storage->exists($resultPaht)) {

            $img = Image::decode($storage->path($realPath));

            [$w, $h] = explode('x', $size);

            $img->{$call}((int) $w, (int) $h);

            $img->save($storage->path($resultPaht));


        }


        return 'storage/' . $resultPaht;

    }
}

/**
 * IP адрес
 */
if (!function_exists('getIp')) {

    function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }
}




/**
 * url2
 */
if (!function_exists('url2')) {

    function url2()
    {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];
        return $url;
    }
}

if (!function_exists('a_url')) {
    function a_url($url = null)
    {

        $d = config('app.app_url');
        if ($url) {
            $a = $d . '/' . $url;
            return trim($a);
        }
        return  false;
    }
}

/* Разрешено ли подключать сторонний сервис (счётчики, CDN, карты, CRM).
   Настройки — config/external.php, в шаблонах есть директива @external. */
if (!function_exists('external')) {
    function external(string $service = null): bool
    {
        $enabled = (bool) config('external.enabled', true);

        if ($service === null) {
            return $enabled;
        }

        // null у сервиса — наследуем общий рубильник
        $own = config('external.services.' . $service);

        return $own === null ? $enabled : (bool) $own;
    }
}

/* Картинка со стороннего домена (фото отелей static.tourvisor.ru).
   Когда сервис выключен, отдаёт серую заглушку вместо ссылки, которая
   из-под VPN всё равно грузится до таймаута. */
if (!function_exists('remote_image')) {
    function remote_image(?string $url, string $service = 'tourvisor_images'): string
    {
        if ($url && external($service)) {
            return $url;
        }

        // заглушка инлайном, чтобы не заводить файл ради dev-режима
        return 'data:image/svg+xml;charset=utf-8,'
            . rawurlencode(
                '<svg xmlns="http://www.w3.org/2000/svg" width="280" height="200">'
                . '<rect width="280" height="200" fill="#eee"/>'
                . '<text x="140" y="104" text-anchor="middle" font-family="sans-serif"'
                . ' font-size="13" fill="#aaa">нет фото</text></svg>'
            );
    }
}

/* Те же флаги для скриптов из resources/js — уезжают в window.EXTERNAL,
   см. layouts/layout.blade.php. */
if (!function_exists('external_flags')) {
    function external_flags(): array
    {
        $flags = ['enabled' => external()];

        foreach (array_keys((array) config('external.services', [])) as $service) {
            $flags[$service] = external($service);
        }

        return $flags;
    }
}




