<?php

namespace App\Http\Controllers;

use App\Crm\Api;
use App\Events\CalcEvent;
use App\Events\OrderCallEvent;
use App\Events\OrderMiniEvent;
use App\Events\PickResponceEvent;
use App\Events\PickSubscriptionEvent;
use App\Events\CertificateOrderEvent;
use App\Events\PickTourEvent;
use App\Events\SendOrderTourEvent;
use App\Events\SignatureEvent;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\User;
use App\Models\UserFavorite;
use App\Models\UserPromo;
use App\View\Composers\TopmenuComposer;
use Domain\Menu\ViewModels\MenuViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AjaxController extends Controller
{

    public $api;

    public function __construct()
    {
        $this->api = new Tourvisor();
    }

    /**
     * Метод  получения session (город)
     */

    public function sity(Request $request)
    {

        session(['sity' => $request->sity]);

        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'sity' => $request->sity
        ]);

    }


    /**
     * Метод отправки сообщения "Заказать звонок"
     */

    public function OrderCall(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'min:5']
        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (заказ звонка)
             */

            OrderCallEvent::dispatch($request);
            $api = new Api();
            $api->SendNewRegigisterUserCRM($request);
            /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */

            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'request' => $request

            ]);
        }

        return response()->json(['error' => $validator->errors()]);

    }

    /**
     * Метод отправки сообщения "Заказать звонок"
     */

    public function OrderMini(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'phone' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'email:dns'],
        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (заявка)
             */

            OrderMiniEvent::dispatch($request);
            $api = new Api();
            $api->SendNewRegigisterUserCRM($request);
            /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */


            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'request' => $request

            ]);
        }

        return response()->json(['error' => $validator->errors()]);

    }

    /**
     * Метод отправки сообщения "Кредитный калькулятор"
     */

    public function Calc(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'phone' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'email:dns'],
        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (расчет с калькулятора туры в кредит)
             */

            CalcEvent::dispatch($request);

            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'request' => $request
            ]);
        }

        return response()->json(['error' => $validator->errors()]);

    }

    /**
     * Метод отправки сообщения "Приобретение сертификата" (страница /sertifikaty)
     */

    public function CertificateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'phone' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'email:dns'],
        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (заявка на сертификат)
             */

            CertificateOrderEvent::dispatch($request);

            $api = new Api();
            $api->SendNewRegigisterUserCRM($request);
            /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */

            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'audience' => $request->audience,
                'amount' => $request->amount,
                'url' => $request->url,
            ]);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    /**
     * Метод отправки сообщения "Подобрать тур"
     */

    public function PickTour(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'phone' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'email:dns'],
            'date' => ['string', 'max:255'],

        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (Подобрать тур)
             */

            PickTourEvent::dispatch($request);

            $api = new Api();
            $api->SendNewRegigisterUserCRM($request);
            /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */


            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date' => $request->date,
                'url' => $request->url,

            ]);


        }

        return response()->json(['error' => $validator->errors()]);

    }


    /**
     * Метод отправки сообщения "Подписаться на рассылку"
     */

    public function PickSubscription(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'phone' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'email:dns'],

        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (Подобрать тур)
             */

            PickSubscriptionEvent::dispatch($request);

            $api = new Api();
            $api->SendNewRegigisterUserCRM($request);
            /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */


            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'url' => $request->url,
                'country' => $request->country,

            ]);

        }

        return response()->json(['error' => $validator->errors()]);

    }


    /**
     * Метод отправки сообщения "Оставить отзыв"
     */

    public function PickResponce(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'responce' => ['required', 'min:5'],
            'email' => ['required', 'email', 'email:dns'],

        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (Оставить отзыв)
             */

            PickResponceEvent::dispatch($request);
            $api = new Api();
            $api->SendNewRegigisterUserCRM($request);
            /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */

            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'name' => $request->name,
                'email' => $request->email,
                'responce' => $request->responce,
                'url' => $request->url,

            ]);
        }

        return response()->json(['error' => $validator->errors()]);

    }


    /**
     * Метод отправки сообщения  подбор конкретного тура с данными из поиска или со страницы отеля
     */

    public function send_order_tour(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'phone' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'email:dns'],

        ]);

        if ($validator->passes()) {

            /**
             * Событие отправка сообщения админу (данные подобронного тура)
             */

            SendOrderTourEvent::dispatch($request);
            $api = new Api();
            $api->SendNewRegigisterUserCRM($request);
            /*** отправка данных в CRM (будет зарегистрирован если нет такого email в CRM) */

            /**
             * возвращаем назад в браузер
             */

            return response()->json([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'url' => $request->url,

                'hotel' => $request->hotel,
                'mealrussian' => $request->mealrussian,
                'sity' => $request->sity,
                'from' => $request->from,
                'to' => $request->to,
                'nights' => $request->nights,
                'adults' => $request->adults,
                'room' => $request->room,
                'tourname' => $request->tourname,
                'price' => $request->price,

            ]);
        }

        return response()->json(['error' => $validator->errors()]);

    }


    public function getHotelInfo(Request $request)
    {


        $url = url()->previous();
        $slugs = explode("/", $url);
        $l1 = $slugs [(count($slugs) - 1)];

        $slugs = explode("/", $request->url);
        $l2 = $slugs [(count($slugs) - 1)];

        if ($l1 == $l2) {
            //reviews=1 - отзывы
            $hotel = $this->api->_get(['hotelcode' => $l1, 'reviews' => '1'], 'hotel.php');

        }

        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'realurl' => $l1,
            'sendurl' => $l2,
            'hotel' => $hotel,
        ]);

    }


    public function getArrayHotels(Request $request)
    {


        $hotels = $this->api->getHotels($request->cоuntry);
        /* $hotels = $request->cоuntry;*/


        /**
         * возвращаем назад в браузер
         */

        return response()->json([

            'array_hotels' => $hotels,
        ]);

    }


    public function uploadAvatar(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'upload_f' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:6096'
        ]);

        if ($validator->fails()) {
            $resp["success"] = false;
            $resp["err"] = $validator->errors()->first('upload_f');
            return json_encode($resp);
        }

        $puth_avatar = false;

        if ($request->hasFile('upload_f')) {

            $storage = Storage::disk('user');
            $destinationPath = 'users/' . auth()->user()->id . '/avatar';

            if (!$storage->exists($destinationPath)) {
                $storage->makeDirectory($destinationPath);
            } else {
                $success = Storage::deleteDirectory($destinationPath);
            }


            $file = $request->file('upload_f');
            $newFileName = $file->getClientOriginalName();

            $file->storeAs('images/' . $destinationPath, $newFileName);
            $puth_avatar = $destinationPath . '/' . $newFileName; // для БД


        }

        if (!$puth_avatar) {
            $avatar = (auth()->user()->avatar) ?: '';

        } else {
            $avatar = $puth_avatar;
        }

        $user = User::query()
            ->where('id', auth()->user()->id)
            ->update([
                'avatar' => $avatar,
            ]);

        $resp = array();
        $resp['success'] = true;
        $resp['mess'] = "Документы успешно загружены";
        $resp['avatar'] = Storage::disk('user')->url($avatar);


        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'success' => $resp['success'],
            'mess' => $resp['mess'],
            'avatar' => $resp['avatar'],

        ]);

    }


    public function uploadAvatarAdminUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'upload_f' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf,webp|max:6096'
        ]);

        if ($validator->fails()) {


            $resp["success"] = false;
            $resp["err"] = $validator->errors()->first('upload_f');
            return json_encode($resp);


        }

        $puth_avatar = false;

        if ($request->hasFile('upload_f')) {

            $storage = Storage::disk('user');
            $destinationPath = 'users/' . $request->id . '/avatar';

            if (!$storage->exists($destinationPath)) {
                $storage->makeDirectory($destinationPath);
            } else {
                $success = Storage::deleteDirectory($destinationPath);
            }


            $file = $request->file('upload_f');
            $newFileName = $file->getClientOriginalName();

            $file->storeAs('images/' . $destinationPath, $newFileName);
            $puth_avatar = $destinationPath . '/' . $newFileName; // для БД

        }

        if (!$puth_avatar) {
            $avatar = (User::find($request->id)->avatar) ?: '';

        } else {
            $avatar = $puth_avatar;
        }

        $user = User::query()
            ->where('id', $request->id)
            ->update([
                'avatar' => $avatar,
            ]);

        $resp = array();
        $resp['success'] = true;
        $resp['mess'] = "Документы успешно загружены";
        $resp['avatar'] = Storage::disk('user')->url($avatar);


        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'success' => $resp['success'],
            'mess' => $resp['mess'],
            'avatar' => $resp['avatar'],

        ]);

    }


    /**
     * Подписание договора
     */

    public function signingContract(Request $request)
    {

        $crm = new Api();

        $responce_crm = $crm->SendCRM($request->id);
        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'id' => $request->id,
            'responce_crm' => $responce_crm,

        ]);

    }

    /**
     * Созданите промокода
     */

    public function getPromoCode(Request $request)
    {

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $promo_code = substr(str_shuffle($permitted_chars), 0, 6);

        $user = auth()->user();
        $error = false;
        if ($user->id == $request->id) {
            UserPromo::query()->create([
                'code' => $promo_code,
                'user_id' => $request->id
            ]);
        } else {
            $error = 'Подтасовка!!!';
        }
        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'id' => $request->id,
            'promo_code' => $promo_code,
            'error' => $error,

        ]);

    }

    /**
     * Получение туров для пользователя
     */

    public function getTours(Request $request)
    {

        //$user = auth()->user();

        $user = User::find($request->user_id); // получили пользователя, для которого получим туры
        $session_user = session()->get('user');

        $crm = new Api();
        $tours = [];
        $error = false;
        $tours = $crm->CRM($user->email);
        if (!$tours) {
            $error = 'No tours for user';
        }
        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'tours' => $tours,
            'error' => $error,

        ]);

    }

    /**
     * Установка бонусов в left_bar в лк
     *
     */

    public function getNewBonus(Request $request)
    {
        $user = auth()->user();
        $bonus = $user->bonus;

        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'bonus' => $bonus,

        ]);

    }

    /**
     * ТЕСТ отправка письма при подписнеии договора
     *
     */

    public function sendEmailSignature(Request $request)
    {

        $user = User::find($request->user_id);
        $body = [];
        $body['contract'] = $request->contract;
        $body['name'] = $user->name;
        $body['email'] = $user->email;
        $body['phone'] = (format_phone($user->phone)) ?: '-';
        $body['date'] = date('d.m.Y');

        /**
         * Событие отправка сообщения пользователю (данные о подписанном туре)
         */

        SignatureEvent::dispatch($body);

        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'data' => $body,

        ]);

    }


    /**
     * Добавление в избранное отеля и туров
     *
     */

    public function insertFavorite(Request $request)
    {

        //  dd($request);

        $data = $request->big_data;

        $city = (isset($data[0]['tours'][0]['tour']['sity'])) ? trim($data[0]['tours'][0]['tour']['sity']) : '';
        $country = (isset($data[0]['tours'][0]['tour']['country'])) ? trim($data[0]['tours'][0]['tour']['country']) : '';

        UserFavorite::query()->create([

            'city' => $city,
            'country' => $country,
            'hotelid' => $request->hotelid,
            'params' => $data, /** отели и туры к ним   */
            'favorite_id' => $request->favorite_id, /** уникальный id по каждой записи, для удаления его */
            'user_id' => auth()->user()->id,/** */

        ]);

        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'type' => $request->type,
            'data' => $data,

        ]);

    }

    /**
     * Удаление  из избранного -  отеля и туров
     *
     */

    public function deleteFavorite(Request $request)
    {
        if ($request->favorite_id) {
            $ok = UserFavorite::query()->where('favorite_id', $request->favorite_id)->delete();
        }


        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'type' => $request->type,
            'res' => $ok,

        ]);

    }

    /**
     * Удаление из избранного (В ЛК user - а) - отеля и туров
     *
     */

    public function deleteFavorite2(Request $request)
    {
        if ($request->favorite_id) {

            $user = auth()->user();


            $ok = UserFavorite::query()
                ->where('favorite_id', $request->favorite_id)
                ->where('user_id', $user->id)
                ->delete();
        }


        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'type' => $request->type,
            'res' => $ok,

        ]);

    }


    /**
     * Формируем мобильное меню
     */
    public function mobile_menu(Request $request)
    {

       // $mobile_menu = MenuViewModel::make()->render_mobile_menu($request->route);

        /** переделал в третий раз  */
        /**
         * возвращаем назад в браузер
         */
        return response()->json([
            'menu' => '' // string  -- render_mobile_menu

        ]);

    }
}
