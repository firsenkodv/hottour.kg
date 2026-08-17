<?php

namespace App\Crm;
use App\Models\User;

class Api
{

    protected $ip_crm = '185.111.106.11';
    protected $login_crm = 'alex';
    protected $port_crm = '8800';
    protected $password_crm = '1234567';


    /**
     * @return array из CRM туры пользователя по email
     */
    public function CRM($email)
    {
        // CRM живёт во внутренней сети и из-под VPN недоступна, а curl ниже
        // идёт без CURLOPT_TIMEOUT — запрос повиснет на всё время ожидания
        // соединения. Флаг crm, см. config/external.php.
        if (!external('crm')) {
            return false;
        }

        $ip_crm = $this->ip_crm;
        $login_crm = $this->login_crm;
        $port_crm = $this->port_crm;
        $password_crm = $this->password_crm;

        $out = [];
        $out2 = [];
        $link = '';
        $id_client = '';
        $user_arr = array();
        $arr = array();

        $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/_service/login';

        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $login_crm . ":" . $password_crm);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);


        $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/user';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out2 = curl_exec($curl);
        $out2 = (json_decode($out2));
        curl_close($curl);


        if ($out2) {
            foreach ($out2->packet as $key => $pack2) {
                $user_arr[$pack2->humanid]['fio'] = (isset($pack2->name))?$pack2->name:'';
                $user_arr[$pack2->humanid]['email'] = (isset($pack2->email))?$pack2->email:'';
                $user_arr[$pack2->humanid]['phone'] = (isset($pack2->phone))?$pack2->phone:'';
            }
        }
        $x = 0;

        $search_found = 0;


        if ($email) {
            $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/recipient?pmail=' . $email; //&pphone=1234
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            $out = curl_exec($curl);
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            $out = (json_decode($out));
            //echo "<pre>";print_r($out);
            if ($out) {
                if (count($out->packet) > 0) {
                    $search_found = 1;
                }
            }
        }


        if ($out) {
            if (count($out->packet) > 0) {
                $id_client = $out->packet[0]->id;
            }
        }



        if ($id_client) {

            $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/reservation?precipientid=' . $id_client . '';  // не зависимо от статуса


            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            $out = curl_exec($curl);
            $out = (json_decode($out));
            curl_close($curl);
            if($out->packet ) {
                foreach ($out->packet as $key => $pack) {


                    $reservationid = $pack->id;
                    $nights = (isset($pack->nights)) ? $pack->nights : '';
                    $statusname = (isset($pack->statusname)) ? $pack->statusname : '';
                    //echo "<hr>";

                    // здесь цикл должен быть

                    $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/reservation/' . $reservationid;
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_URL, $link);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
                    curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    $out = curl_exec($curl);
                    $out = (json_decode($out));
                    curl_close($curl);

                    //    dump($out);

                    $arr[$x]['id'] = $out->packet->id;
                    $arr[$x]['user_id'] = (isset($id_client)) ? $id_client : '';
                    $arr[$x]['number'] = (isset($out->packet->number)) ? $out->packet->number : '';
                    $arr[$x]['info'] = (isset($out->packet->info)) ? $out->packet->info : '';

                    $arr[$x]['summ'] = (isset($out->packet->cost)) ? $out->packet->cost : '';
                    $arr[$x]['price'] = (isset($out->packet->cost)) ? price($out->packet->cost) : '-';
                    $arr[$x]['currencyname'] = (isset($out->packet->currencyname)) ? $out->packet->currencyname : '';
                    $arr[$x]['currency'] = (isset($out->packet->currencyname)) ? currency($out->packet->currencyname) : '';
                    $arr[$x]['signaturedate'] = (isset($out->packet->signaturedate)) ? $out->packet->signaturedate : '';
                    $arr[$x]['from'] = (isset($out->packet->subclaim[0]->forder[0]->fromtownname)) ? $out->packet->subclaim[0]->forder[0]->fromtownname : '-';
                    $arr[$x]['to'] = (isset($out->packet->subclaim[0]->countryname)) ? $out->packet->subclaim[0]->countryname : '';
                    $arr[$x]['legalname'] = (isset($out->packet->subclaim[0]->legalname)) ? $out->packet->subclaim[0]->legalname : '';
                    $arr[$x]['nights'] = $nights;
                    $arr[$x]['statusname'] = $statusname;
                    $arr[$x]['datebeg'] = (isset($out->packet->datebeg))?$out->packet->datebeg:'';
                    $arr[$x]['dateend'] = (isset($out->packet->dateend))?$out->packet->dateend:'';
                    $arr[$x]['hotelname'] = (isset($out->packet->subclaim[0]->horder[0]->hotelname))?$out->packet->subclaim[0]->horder[0]->hotelname:'';
                    $arr[$x]['pdate'] = (isset($out->packet->pdate))?$out->packet->pdate:'';
                    $arr[$x]['cdate'] = (isset($out->packet->cdate))?$out->packet->cdate:'';
                    $managerid = (isset($out->packet->people[0]->managerid))?$out->packet->people[0]->managerid:'';
                    $user_arr[$managerid]['human_fio'] = (isset($out2->packet[0]->name))?$out2->packet[0]->name:'';
                    $arr[$x]['managerid'] = $managerid;
                    $arr[$x]['human_fio'] = $user_arr[$managerid]['fio'];
                    $arr[$x]['human_email'] = $user_arr[$managerid]['email'];
                    $arr[$x]['human_phone'] = $user_arr[$managerid]['phone'];


                    /* подписание договора */
                    /* варианты */
                    $podpis_html = '<span class="d_green22">Подписан</span>';
                    $nepodpis_html = '<span class="d_red22">Не подписан</span> <span class="signature22">Подписать</span>';
                    /* //варианты */
                    /* подписано */
                    $arr[$x]['podpis'] = $podpis_html;

                    /* //подписано */
                    if ($arr[$x]['signaturedate']) { // подпись есть!
                        $signature = true;
                        $signaturedate = $arr[$x]['signaturedate'];
                        $arr[$x]['signaturedate22'] = date("d-m-Y", strtotime($signaturedate));
                    } else { // подпись НЕТ!
                        $signature = false;
                        $signaturedate = $arr[$x]['pdate'];
                        $arr[$x]['signaturedate22'] = date("d-m-Y", strtotime($signaturedate));
                    }
                    if ($arr[$x]['statusname'] == 'Неоплачена' and !$signature) { // если неоплаченная и нет подписи
                        $arr[$x]['podpis'] = $nepodpis_html;
                    }
                    $arr[$x]['podpis_html'] = $podpis_html; // для js подставить договор подписан, после подписания.
                    /* подписание договора */

                    if ($arr[$x]['signaturedate']) { // подпись есть!

                        if(isset($out->packet->cost)) {
                            $summ = $out->packet->cost;
                            $bbb = ceil((int)$summ / 100 * 0.2); // новые бонусы
                            if ($bbb > 15000) $bbb = 15000; // не более 15000 бонусов
                            $arr[$x]['bonus'] = price($bbb);
                        } else {
                            $arr[$x]['bonus'] = 0;
                        }
                    } else {
                        $arr[$x]['bonus'] = 0;
                    }
                    $x++;

                }
            }// if



            //$sortBy = 'datebeg';

            $arr = $this->SortObjectSetBy($arr, 'datebeg');
            $result = $this->saveBonusForUser($arr); /** записшем на счет user -a бонусы за туры **/
//          dd(array_shift($arr));

            //   dd((int)array_shift($arr)['summ']);
            //   dd($out->packet);
            //   dd(array_shift($arr));


            return $arr;

        }
        return false;
    }

    /**
     * @return array сортировка массива из CRM по дате вылета ( datebeg )
     */
    public function SortObjectSetBy($objectSetForSort, $sortBy)
    {

        usort($objectSetForSort, function ($object1, $object2) use ($sortBy) {
            $a_new = strtotime($object1[$sortBy]);
            $b_new = strtotime($object2[$sortBy]);
            return $b_new - $a_new;

        }); // конец  usort

        return $objectSetForSort;
    }


    /**
     * @return array подписание договора
     */
    public function SendCRM($id)
    {
        // см. комментарий в CRM(): без флага заявка просто не уходит в CRM
        if (!external('crm')) {
            return false;
        }

        $ip_crm = $this->ip_crm;
        $login_crm = $this->login_crm;
        $port_crm = $this->port_crm;
        $password_crm = $this->password_crm;

        //  $s = $this->settingCRM();


        $id1 = $id; // id заказа (заявка)
        $signaturedate = date('c'); // дата подписания договора


        $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/_service/login';
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $login_crm . ":" . $password_crm);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);

        /*---------блокировка перед обновлением-------------*/
        $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/reservation/' . $id1 . '/lock';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIESESSION, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $out = (json_decode($out));
        /*echo "<pre>";
        print_r($out);
        echo "</pre><hr>";*/
        curl_close($curl);

        $hash = $out->{'__hash__'};


        /*---------обновление-------------*/
        $data = array(
            'packet' => array(
                'id' => $id1,
                'cdate' => $signaturedate,
                'signaturedate' => $signaturedate
            ),
            "__hash__" => $hash,
        );

        $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/reservation/' . $id1;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIESESSION, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $out = (json_decode($out));
        curl_close($curl);

        /*-----------закрытие текущей сессии-----------------------*/

        $link = 'http://' . $ip_crm . ':' . $port_crm . '/api/v1/_service/logout';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIESESSION, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $out = curl_exec($curl);
        $out = (json_decode($out));
        curl_close($curl);
        return true;

    }

    /**
     * запись в БД бонусы
     */
    public function saveBonusForUser($arr = null, $user_id = null)
    {




        if (is_null($arr)) {
            return false;
        }

        if (is_null($user_id)) {
            $user_id = auth()->user()->id;
        }

        foreach ($arr as $item) {
            /** ищем первый подписанный **/
            if ($item['signaturedate']) {

              $user = User::query()->where('id', $user_id)->first();


              if(is_null($user->bonus)) {
                  $user->bonus = price_reverse($item['bonus']);
              } else {
                  if($user->bonus != $item['bonus']) {
                      $user->bonus =  price_reverse($item['bonus']);
                  }
              }

              /** поставим заглушку **/
                if ($user->bonus > 15000) $user->bonus = 15000; // не более 15000 бонусов

                $user->save();
                return true;

            }
        }
        return false;
    }






    public   function SendNewRegigisterUserCRM($request)
    {

        $ip_crm = $this->ip_crm;
        $login_crm = $this->login_crm;
        $port_crm = $this->port_crm;
        $password_crm = $this->password_crm;

        $name =  $request->name;
        $phone =  $request->phone;
        $email =  $request->email;
        $address =  $request->address;

        $link =  'http://'.$ip_crm.':'.$port_crm.'/api/v1/_service/login';
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $login_crm . ":" . $password_crm);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);




        $search_found = 0;
        /*-----------------поиск по емайл-------------------------------------*/
        if ($email){
            $out='';
            $link='http://'.$ip_crm.':'.$port_crm.'/api/v1/recipient?pmail='.$email; //&pphone=1234
            $curl=curl_init();
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_URL,$link);
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
            curl_setopt($curl,CURLOPT_HEADER,false);
            curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
            curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
            $out=curl_exec($curl);
            $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
            curl_close($curl);
            $out=(json_decode($out));
            //echo "<pre>";print_r($out);
            if (count($out->packet)>0){
                $search_found = 1;
            }
        }


        if ($search_found==0) {

            $data = array(
                'packet' =>
                    array(
                        "name" => $name,
                        "phone" => ($phone)?:'-',
                        "email" => $email,
                        "rtypeid" => "1",
                        "address" => ($address)?:'-',
                        "human" => array(
                            array(
                                "human" => "ADL",
                                "mobile" => ($phone)?:'-'
                            ))
                    )
            );
            $link = 'http://'.$ip_crm.':'.$port_crm.'/api/v1/recipient';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
            curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            $result = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            return $http_code;
        } else {
            return  'CLIENT_LOAD_BACK';
        }
    }




}
