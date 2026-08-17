<?php

namespace Domain\Payment\ViewModels;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Makeable;

class PaymentViewModel
{
    use Makeable;

    //public string $url_register = 'https://3dsec.berekebank.kz/payment/rest/register.do';
    public string $url_register = 'https://securepayments.berekebank.kz/payment/rest/register.do';


    //public string $url_status = 'https://3dsec.berekebank.kz/payment/rest/getOrderStatusExtended.do';
    public string $url_status = 'https://securepayments.berekebank.kz/payment/rest/getOrderStatusExtended.do';


    public  string $userName = 'hottour-api';
    public  string $password =  'Password*123';

   // public  string $userName =  'director-test1-api';
   // public  string $password =  'qgzpa-G7';
    public  string $language =  'ru';

    public function customAmount($request)
    {

        $amount =  $this->multiplyBy100($request->amount);

        $url = $this->url_register;

        $data = [
            'amount' => $amount,
            'currency' => 398,
            'userName' => $this->userName,
            'password' => $this->password,
            'returnUrl' => route('cabinet_return_order'),
            'description' => ($request->payment_desc) ?? ' - ',
            'language' => $this->language,
            'orderNumber' => $this->generateUniqueNumericCode()
        ];


 /*           dump('Массив data который отправляем');
              dd($data);*/

        $result = $this->curlSet($url, $data);

        if (isset($result->errorCode)) {
            return false;
        }

 /*       dd($result);*/
        // $this->saveOrder($result->orderId, $amount); //запишем

        return $result->formUrl;

    }

    public function returnOrder($request):array | null
    {

        /**
         * status = 3 нужно проверить оплату через крон
         * status = 2 пользователю проходить 3D security
         * status = 1 успешная оплата
         */

        /**
         * 0 - заказ зарегистрирован, но не оплачен;
         * 1 - заказ только авторизован и еще не завершен (для двухстадийных платежей);
         * 2 - заказ авторизован и завершен;
         * 3 - авторизация отменена;
         * 4 - по транзакции была проведена операция возврата;
         * 5 - инициирована авторизация через ACS банка-эмитента;
         * 6 - авторизация отклонена;
         * 7 - ожидание оплаты заказы;
         * 8 - промежуточное завершение для многократного частичного завершения.
         */


        /**
         * Получение статуса платежа
         */
        $url = $this->url_status;
        $data = [
            'userName' => $this->userName,
            'password' => $this->password,
            'orderId' => $request->orderId,
            'language' => $this->language,
            ];



        $result =  $this->curlSet($url, $data);

        $array = [];
        if($result) {
            $array['order_number'] = $result->orderNumber;
            $array['amount'] = $result->amount / 100;
            $array['desc'] = $result->orderDescription;
            $array['user_id'] = auth()->id();
            $array['order_id'] = $request->orderId;
            $array['currency'] = $result->currency;
            $array['order_status'] = $result->orderStatus;
            $array['data'] = $result;
            $array['lang'] = $this->language;
        }

        return (count($array)) ? $array : null;

    }


    public function curlSet($url, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

       /* dd($response);*/

        if ($response === false) {

            /*dump('Ошибка cURL: ' . curl_error($ch));*/
            curl_close($ch);

            return false;

        } else {

            /*
               dump('Нет ошибки cURL, запрос ушел');
               dump('Пришел ответ');
               dump('Ответ сервера: ' . $response);
               dump('Повторно выводим массив который отправили.');
            */
            /*   dd($data);  */

            $decode_response = json_decode($response);
            curl_close($ch);

            return $decode_response;

        }

    }

    public function saveOrder($data)
    {
             return Payment::create($data);
    }

    public function userPayments($user_id, $paginate = false):LengthAwarePaginator | Collection
    {

        $q = Payment::query();
        $q->where('user_id', $user_id);
        $q->orderBy('created_at', 'desc');
        if($paginate) {
            return $q->paginate(config('site.constants.paginate'));
        }
       return $q->get();
    }

    protected function multiplyBy100($sum):bool | int {

        if (!$sum) {
           return false;
        }

        /** Пробуем конвертировать строку в целое число и убедиться, что это успешно прошло **/
        $convertedNumber = filter_var($sum, FILTER_VALIDATE_INT);

        if($convertedNumber !== false && $convertedNumber > 0) /** Только положительные целые числа **/
        {
            return $sum * 100;

        } else {
            return false;
        }
    }

    protected function generateUniqueNumericCode(): int
    {
        do {
            /** Берём текущие секунды времени Unix **/
            $timestamp = time();

            /** Случайное число от 100 до 999 (для увеличения разнообразия) **/
            $randomPart = random_int(100, 999);

            /** Форматируем код как целое число длиной минимум 7 символов **/
            $code = ($timestamp * 1000) + $randomPart;

        } while (Payment::where('order_number', $code)->exists());

        return $code;
    }

}
