<?php

namespace App\Http\Controllers\Tourvisor\Service;
use Illuminate\Http\Request;

class Ajax
{
    public $api;

    public $input;

    public function __construct(Request $request)
    {
        $this->api = new Tourvisor();

        if(isset($request->action)) {

            $this->input = $request->all();

        }
        else
        {
            $this->input = json_decode(file_get_contents('php://input'), true);
        }
    }

    public function getRegion(){
        $params =  $this->input;

        if(!empty($params['onlyHotels'])){
            return $this->api->getHotels($params['country_id']);
        } else {
            $result = $this->api->getRegions($params['country_id']);
            $hotels = $this->api->getHotels($params['country_id']);
            $result->lists->hotels = $hotels->lists->hotels;
            $result->regions = $this->getRegionsHtml($result->lists->regions->region);

            return $result;
        }
    }

    public function getRegionsHtml($list){
        $html = '';
        foreach($list as $region) {
            $html .= '<label class="checkbox_choice__item">' ;
            $html .= '<input class="region_checkbox" type="checkbox" name="region[]" value="' . $region->id . '" data-title="' . $region->name . '">';
            $html .= '<span>'. $region->name .'</span></label>';
        }
        return $html;
    }

    public function continueSearchTour(){
        $params =  $this->input;
        return $this->api->_get($params, 'search.php');
    }

    public function searchTour(){
        $params =  $this->input;
        if(is_array(@$params['region'])) {
            $params['regions'] = implode(",",$params['region']);
        } else {
            $params['regions'] = @$params['region'];
        }
        unset($params['region']);
       // config('currency.currency');
       // $params['currency'] = 3;
        /*        if($_SESSION['currency']){
                    switch ($_SESSION['currency']){
                        case "RUB": $params['currency'] = 0; break;
                        case "KZT": $params['currency'] = 3; break;
                        case "BLR": $params['currency'] = 2; break;
                        default: $params['currency'] = 1; break; // USD или EUR в зависимости в чем оператор выдает
                    }
                }*/
        if(is_array(@$params['services'])) $params['services'] = implode(",",$params['services']);
        if(is_array(@$params['hotels'])) $params['hotels'] = implode(",",$params['hotels']);
        $dataRenge = explode(" - ",$params['daterange']);
        unset($params['daterange']);
        $params['datefrom'] = trim($dataRenge[0]);
        $params['dateto'] = trim($dataRenge[1]);
        $params['currency'] = 3;
        if(!empty($params['s_star'])){
            $params['stars'] = $params['s_star'];
            unset($params['s_star']);
        }
        if(!empty($params['hotelrating'])){
            $params['rating'] = $params['hotelrating'];
            unset($params['hotelrating']);
        }

        $child = explode(":",@$params['child']);
        $infant = @$params['infant'];
        if(empty($params['priceto'])){
            $params['priceto'] = 10000000;
        } else {
            $params['priceto'] = (int)trim(str_replace([' ', ' '], '', $params['priceto']));
        }
        if(empty($params['pricefrom'])){
            $params['pricefrom'] = 0;
        } else {
            $params['pricefrom'] = (int)trim(str_replace([' ', ' '], '', $params['pricefrom']));
        }

        unset($params['infant']);

        $params['child'] = 0;

        $_i = 1;

        if(!empty($child)){
            $params['child'] = $child[0];
            if(!empty($child[1])) {
                $year = explode(',',$child[1]);

                foreach ($year as $_y){
                    $params["childage{$_i}"] = (int)$_y;
                    $_i++;
                }
            }
        }

        if(!empty($infant)){
            $params['child'] += $infant;
            for($i=0;$i<$infant;$i++){
                $params["childage{$_i}"] = 1;
                $_i++;
            }
        }

        $result = $this->api->_get($params, 'search.php');
        /**
         * Просмотр url запроса к tourvisor - у
         */
     //   $result->last_request = $this->api->last_request;
        /**
         * Просмотр url запроса к tourvisor - у
         */
        return $result;
    }

    public function searchTourStatus(){
        $params['requestid'] = $this->input['requestid'];
        $params['type'] = 'status';
        return $this->api->_get($params, 'result.php');
    }

    public function searchTourResult(){
        $params['requestid'] = $this->input['requestid'];
        if(!empty($this->input['page'])){
            $params['page'] = $this->input['page'];
        };
        $params['type'] = 'result';

        if(!empty($this->input['page']))
            $params['page'] = $this->input['page'];
        $result = $this->api->_get($params, 'result.php');


       //  dd($result->data->result->hotel[0]->tours->tour[0]->tourid);
      //  dd($result);
        if($result->data->status->hotelsfound > 0) {

            foreach ($result->data->result->hotel as $key => $hotel) {


                $hotel_result = $this->api->_get(['hotelcode' => $hotel->hotelcode], 'hotel.php');

                $result->data->result->hotel[$key]->hotels_info = $hotel_result->data->hotel;

                // попытка получения онформации о полетах
                // большой объем данных (не тянет)

/*                foreach($hotel->tours->tour as $k=> $tour) {

                    $params_flight['tourid'] = $tour->tourid;
                    $params_flight['currency'] = 3;
                    $flight_result = $this->api->_get($params_flight, 'actdetail.php');
                    $result->data->result->hotel[$key]->tours->tour[$k]->flights =  (object) $flight_result;

                }*/


                if (!empty($hotel_result->data->hotel->coord1)) {
                    $result->data->result->hotel[$key]->hotels_info->addinfo = (object)['coord1' => $hotel_result->data->hotel->coord1, 'coord2' => $hotel_result->data->hotel->coord2];
                } else {
                    $result->data->result->hotel[$key]->hotels_info->addinfo = (object)['coord1' => '', 'coord2' => ''];
                }


                $result->data->result->hotel[$key]->price_for_site = $hotel->tours->tour[0]->price;

            } // end foreach

        }

       // dd($result);

        return $result;
    }

}


