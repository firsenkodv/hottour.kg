<?php

namespace App\Http\Controllers\Excel;

use App\Events\OrderCallEvent;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\HotCategory;
use App\Models\Hotel;
use App\Models\User;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ExcelController
{
    public function import(Request $request)
    {




        $file = $request->file('import_file');

        $importedData = (new FastExcel)->import($file, function ($line) {
            Hotel::updateOrCreate(['slug' => $line['slug']],
                [
                    'title' => $line['title'],
                    'slug' => $line['slug'],
                    'hot_category_id' => $line['hot_category_id'],
                    'country_id' => ($line['country_id'])?:null,
                    'region_id' => ($line['region_id'])?:null,
                    'stars' => ($line['stars'])?:null,
                    'rating' => ($line['rating'])?:null,
                    'placement' => ($line['placement'])?:'',
                    'desc' => ($line['desc'])?:'',
                    'imagescount' => ($line['imagescount'])?:0,
                    'params' => ($line['params'])?:null,
                    'region' => ($line['region'])?:'',
                    'build' => ($line['build'])?:'',
                    'coord' => ($line['coord'])?:'',
                    'metatitle' => ($line['metatitle'])?:'',
                    'description' => ($line['description'])?:'',
                    'keywords' => ($line['keywords'])?:'',
                    ]);
        });


        return redirect()->back()->with('success', 'Data imported successfully');
    }

    public function showImportExportView()
    {






        $email = 'nadyasaf070@gmail.com';


        $username =   'alex';
        $password =   '1234567';
        $link =  'http://185.111.106.11:8800/api/v1/_service/login';
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);

        /*
        echo "<pre>";
        print_r($result);
        die();*/




        $link='http://185.111.106.11:8800/api/v1/user';
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out2=curl_exec($curl);
        $out2=(json_decode($out2));
        curl_close($curl);


        $user_arr=array();
        foreach ($out2->packet as $key => $pack2){
            $user_arr[$pack2->humanid]['fio']=$pack2->name;
            $user_arr[$pack2->humanid]['email']=$pack2->email;
            $user_arr[$pack2->humanid]['phone']=$pack2->phone;
        }

        $arr=array();
        $x=0;
        $search_found=0;
        /*-----------------поиск по емайл-------------------------------------*/
        if ($email){
            $out='';
            $link='http://185.111.106.11:8800/api/v1/recipient?pmail='.$email; //&pphone=1234
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

            if (count($out->packet)>0){
                $search_found=1;
                //$forsechumanid=$out->forsechumanid;
            }
        }


        /*--------------------------------------------------------------------*/

        $id_client=$out->packet[0]->id;
        if ($id_client){

            $link='http://185.111.106.11:8800/api/v1/reservation?precipientid='.$id_client.'&pstatusid=1'; // оплачен
            $link='http://185.111.106.11:8800/api/v1/reservation?precipientid='.$id_client.'';  // не зависимо от статуса


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
            $out=(json_decode($out));
            curl_close($curl);


            foreach ($out->packet as $key => $pack){
                $reservationid=$pack->id;
                $nights=$pack->nights;
                $statusname=$pack->statusname;
                //echo "<hr>";

                // здесь цикл должен быть

                $link='http://185.111.106.11:8800/api/v1/reservation/'.$reservationid;
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
                $out=(json_decode($out));
                curl_close($curl);

                //echo "<pre>";print_r($out);
                //die();
                //dd($out->packet);
                if ($out->packet->attachedfiles){

                    foreach ($out->packet->attachedfiles as $attach){
                        $link='http://185.111.106.11:8800/api/v1/reservation/'.$attach->documentid.'/attachedfiles/'.$attach->id.'';
                        $curl=curl_init();
                        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true); curl_setopt($curl,CURLOPT_URL,$link); curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET'); curl_setopt($curl,CURLOPT_HEADER,false); curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0); curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
                        $out_file=curl_exec($curl);
                        curl_close($curl);

                        if (!file_exists(__DIR__.'/files/'.$attach->documentid)) {
                            mkdir(__DIR__.'/files/'.$attach->documentid, 0777, true);
                        }

                        file_put_contents(__DIR__.'/files/'.$attach->documentid.'/'.$attach->name, $out_file);
                        $arr[$x]['attach'][]='http://site.ru/files/'.$attach->documentid.'/'.$attach->name;
                    }
                    $arr[$x]['test']='$out->packet->attachedfiles';
                }

                $arr[$x]['summ']=$out->packet->cost;
                $arr[$x]['currencyname']=$out->packet->currencyname;
                $arr[$x]['from']=$out->packet->subclaim[0]->forder[0]->fromtownname;
                $arr[$x]['to']=$out->packet->subclaim[0]->countryname;


                $arr[$x]['legalname']=$out->packet->subclaim[0]->legalname;

                $arr[$x]['nights']=$nights;
                $arr[$x]['statusname']=$statusname;

                $arr[$x]['datebeg']=$out->packet->datebeg;
                $arr[$x]['dateend']=$out->packet->dateend;

                $arr[$x]['hotelname']=$out->packet->subclaim[0]->horder[0]->hotelname;
                $arr[$x]['pdate']=$out->packet->pdate;
                $arr[$x]['number']=$out->packet->number;
                $arr[$x]['cdate']=$out->packet->cdate;



                $managerid=$out->packet->people[0]->managerid;


                //$user_arr[$managerid]['human_fio']=$out2->packet[0]->name;
                //$arr[$x]['managerid']=$managerid;
                $arr[$x]['human_fio']=$user_arr[$managerid]['fio'];
                $arr[$x]['human_email']=$user_arr[$managerid]['email'];
                $arr[$x]['human_phone']=$user_arr[$managerid]['phone'];

                $x++;

            }

           // dd($arr);

        }


              return view('excel.import');
    }

}
