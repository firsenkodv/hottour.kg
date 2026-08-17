<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Bitrix24\Bitrix24;
use App\Http\Controllers\Controller;
use App\Models\MoonshineSetting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class MoonshineSettingController extends Controller
{
    public function __invoke(Request $request): Response
    {

        $n = explode("/", $_SERVER['HTTP_REFERER']);
        $key = array_pop($n);

        $result = MoonshineSetting::query()->updateOrCreate(
            ['key' => $key],
            [
                'key'=> $key,
                'bonus'=> (isset($request->bonus))? $request->bonus :null,
                'ball'=> (isset($request->ball))? $request->ball :null,
                'cashback'=> (isset($request->cashback))? $request->cashback :null,
                'fullAddress'=> (isset($request->fullAddress))? $request->fullAddress :null,
                'address'=> (isset($request->address))? $request->address :null,
                'country'=> (isset($request->country))? $request->country :null,
                'sityAddress'=> (isset($request->sityAddress))? $request->sityAddress :null,
                'idn'=> (isset($request->idn))? $request->idn :null,
                'phone1'=> (isset($request->phone1))? $request->phone1 :null,
                'phone2'=> (isset($request->phone2))? $request->phone2 :null,
                'company_name'=> (isset($request->company_name))? $request->company_name :null,
                'bin'=> (isset($request->bin))? $request->bin :null,
                'whatsapp'=> (isset($request->whatsapp))? $request->whatsapp :null,
                'telegram'=> (isset($request->telegram))? $request->telegram :null,
                'facebook'=> (isset($request->facebook))? $request->facebook :null,
                'instagram'=> (isset($request->instagram))? $request->instagram :null,
                'youtube'=> (isset($request->youtube))? $request->youtube :null,

            ]);

        $this->saveBitrix24($request);

        return back();
    }

    /**
     * Доступы к Битрикс24 лежат не в moonshine_settings, а группой `bitrix24`
     * в settings — таблица с плоскими колонками под них не рассчитана.
     * Форма у страницы одна, поэтому сохраняем обе части здесь.
     */
    private function saveBitrix24(Request $request): void
    {
        $setting = Setting::getGroup(Bitrix24::GROUP);

        $setting->data = [
            'bx_enabled' => (bool) $request->boolean('bx_enabled'),
            'bx_webhook' => $request->input('bx_webhook'),
            'bx_resp_id' => $request->input('bx_resp_id'),
            'bx_email_to' => $request->input('bx_email_to'),
        ];

        $setting->save();
    }
}
