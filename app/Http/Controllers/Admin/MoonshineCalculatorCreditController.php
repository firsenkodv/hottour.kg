<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MoonshineCalculator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class MoonshineCalculatorCreditController extends Controller
{
    public function __invoke(Request $request): Response
    {

        $n = explode("/", $_SERVER['HTTP_REFERER']);
        $key = array_pop($n);

        $result = MoonshineCalculator::query()->updateOrCreate(
            ['key' => $key],
            [
                'key'=> $key,
                'banks'=> (isset($request->banks))? $request->banks :null,
                'countries'=> (isset($request->countries))? $request->countries :null,
            ]);


        return back();
    }
}
