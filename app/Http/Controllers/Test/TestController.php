<?php

namespace App\Http\Controllers\Test;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;


class TestController extends Controller
{

  //  public string $url_register = 'https://3dsec.berekebank.kz/payment/rest/register.do';
    public string $url_register = 'https://securepayments.berekebank.kz/payment/rest/register.do';


   // public string $url_status = 'https://3dsec.berekebank.kz/payment/rest/getOrderStatusExtended.do';
    public string $url_status = 'https://securepayments.berekebank.kz/payment/rest/getOrderStatusExtended.do';


    public function bereke()
    {

        return view('pages.bereke.bereke', []);

    }

    public function customAmount(Request $request)
    {

        if (!$request->amount) {
            abort(404);
        }

        $url = $this->url_register;
        $amount = $request->amount;

        $data = [
            'amount' => $amount,
            'currency' => 398,
            'userName' => 'hottour-api',
            'password' => 'Password*123',
            'returnUrl' => config('app.url') . '/return-order',
            'description' => 'Мини описание покупки',
            'language' => 'ru',
            'orderNumber' => rand(1,10000)
        ];



      /*   dump('Массив data который отправляем');
         dd($data);*/

         $result = $this->curlSet($url, $data);

        /*dd($result);*/

        if(isset($result->errorCode)) {
            flash()->alert(config('message_flash.alert.bereke_error'));
            return redirect()->back();
        }

          // $this->saveOrder($result->orderId, $amount); //запишем
            return redirect($result->formUrl);

    }

    public function returnOrder(Request $request)
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
        /*  'userName' => 'director-test1-api',
            'password' => 'qgzpa-G7',  */
            'userName' => 'hottour-api',
            'password' => 'Password*123',
            'orderId' => $request->orderId,
            'language' => 'ru'
        ];

        $result = $this->curlSet($url, $data);
        dd($result);

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

        if ($response === false) {

              dump('Ошибка cURL: ' . curl_error($ch));
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

    public function saveOrder($id, $amount)
    {

        return true;

        /*      return Order::create([
                  'amount' => $amount,
                  'bank_order_id' => $id,
                  'status' => 0,
              ]);
        */
    }


    public function test()
    {
        /** Перенос пользователей **/
        /** Перенос пользователей **/
        /** Перенос пользователей **/
        /** Перенос пользователей **/

        dd('app/Http/Controllers/Test/TestController.php');
        ini_set('max_execution_time', 180); //3 minutes
        $filename = asset(Storage::url('/images/1.txt'));
        $content = file_get_contents($filename);
        $array = json_decode($content);

        $newarray = [];
        foreach ($array as $item) {
            if ($item->email) {
                $newarray[$item->id]['name'] = $item->username;
                $newarray[$item->id]['email'] = $item->email;

                if ($item->phone) {
                    $newarray[$item->id]['phone'] = phone($item->username);
                }

                $flight[] = User::updateOrCreate(
                    ['email' => $newarray[$item->id]['email']],
                    ['phone' => (isset($newarray[$item->id]['phone'])) ? $newarray[$item->id]['phone'] : null,
                        'name' => $newarray[$item->id]['name'],
                        'password' => bcrypt(time()),

                    ]
                );

            }
        }


        dd($flight);

    }


}
