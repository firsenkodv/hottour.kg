<?php

namespace App\Http\Controllers\Cart;

use App\Models\User;
use App\Models\UserCart;
use Domain\Hotel\ViewModels\HotelViewModel;
use Illuminate\Http\Request;

class CartController
{

    public function cart_form(Request $request)
    {

        if (cart()) {


            $data = json_decode($request->tour_data);


            if ($data) {

                $hotels = [];
                $new_hotels = [];

                foreach ($data as $h) {

                    $hotel_ids[$h->hotel] = $h->hotel;

                }

                $hotels = HotelViewModel::make()->Hotels($hotel_ids); // array c ключами из slug


                foreach ($data as $k => $datum) {

                    if ($datum->hotel == (isset($hotels[$datum->hotel])) ? (int)$hotels[$datum->hotel]['slug'] : 0) {

                        $data[$k]->site_hotel = (object)$hotels[$datum->hotel];

                    } else {

                        $data[$k]->site_hotel = null;

                    }

                }

                session(['tour_data' . auth()->user()->id => $data]); // запустим сессию

            } else {
                $data = [];
                flash()->alert(config('message_flash.alert.cart_empty'));
                return redirect()->intended(route('search_new_tours')); // intended - назад или route

            }



            return view('cart/cart', [
                'tour_data' => $data,
            ]);
        }

     //   return false;


    }


    public function cart()
    {

        if (cart()) {

            settype($tour_data, "array");
            if (session()->get('tour_data' . auth()->user()->id)) {
                $tour_data = session()->get('tour_data' . auth()->user()->id);
            }
            return view('cart/cart', ['tour_data' => $tour_data]);
        }
        return view('cart/cart', []);
    }


    public function cart_form_step2(Request $request)
    {

        settype($tour_data, "array");
        $tour_data = session()->get('tour_data' . auth()->user()->id);

        if ($tour_data) {

            if (cart()) {
                settype($new_tour_data, "array");
                $url = time() . uniqid();
                $request_tour_data = json_decode($request->tour_data);


                if (is_null($request_tour_data)) {
                    /** все туры остались неизменны */

                    $city = (isset($tour_data[0]->tours[0]->tour->sity)) ? trim($tour_data[0]->tours[0]->tour->sity) : '';
                    $country = (isset($tour_data[0]->site_hotel->country_id)) ? getCountryName($tour_data[0]->site_hotel->country_id) : '';

                    if (!is_null($tour_data)) {
                        $order = UserCart::query()->create([
                            'city' => $city,
                            'country' => $country,
                            'region' => '',
                            'params' => $tour_data, /** отели и туры к ним   */
                            'url' => $url, /** ссылка    */
                            'user_id' => auth()->user()->id,/** закрепляем за менеджером? админом или РОП   */

                        ]);

                        session()->forget('tour_data' . auth()->user()->id);

                    }

                } else {

                    /**---------------------------------------------------------------------------------*/
                    /** делаем новый актуальный массив отелей с турами для сохранения  */

                    /*       dump($request_tour_data);
                             dump(session()->get('tour_data'.auth()->user()->id));  */


                    if (session()->get('tour_data' . auth()->user()->id)) {


                        foreach ($tour_data as $t) {

                            foreach ($request_tour_data as $nt) {

                                if ($nt->hotel == $t->hotel) {

                                    $new_tour_data[] = $t;

                                }
                            }

                        }

                        session()->forget('tour_data' . auth()->user()->id);

                        if (!is_null($new_tour_data)) {

                            $city = (isset($new_tour_data[0]->tours[0]->tour->sity)) ? trim($new_tour_data[0]->tours[0]->tour->sity) : '';
                            $country = (isset($new_tour_data[0]->site_hotel->country_id)) ? getCountryName($new_tour_data[0]->site_hotel->country_id) : '';


                            $order = UserCart::query()->create([

                                'city' => $city,
                                'country' => $country,
                                'region' => '',
                                'params' => $new_tour_data, /** отели и туры к ним   */
                                'url' => $url, /** ссылка    */
                                'user_id' => auth()->user()->id,/** закрепляем за менеджером? админом или РОП   */

                            ]);

                        }

                    }

                }

                $orders = UserCart::query()
                    ->where('user_id', auth()->user()->id)
                    ->orderBy('created_at', 'desc')->get();

                return view('cart/cart_finish', [
                    'orders' => $orders,
                ]);


            }


            flash()->alert(config('message_flash.alert.role_error'));
            return redirect()->intended(route('search_new_tours')); // intended - назад или route

        }


        return redirect(route('cart_orders'));


    }

    public function cart_form_finish()
    {

        return redirect(route('cart_orders'));

    }

    public function cart_orders()
    {


        settype($orders, "array");
        if (auth()->user()) {

               $orders = UserCart::query()
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')->get();

        } else {
            flash()->alert(config('message_flash.alert.role_error'));
            return redirect()->intended(route('home')); // intended - назад или route

        }



        return view('cart/cart_finish', [
            'orders' => $orders,
        ]);

    }

    public function cart_form_clear(Request $request)
    {


        $order = UserCart::query()
            ->where('id', $request->order_id)
            ->where('user_id', auth()->user()->id)->delete();

        return redirect(route('cart_orders'));

    }


    public function collection_tours($url)
    {


        $collection = UserCart::query()
            ->where('url', $url)
            ->first();


        return view('cart/cart_collection', [
            'tour_data' => $collection,
        ]);

    }
}
