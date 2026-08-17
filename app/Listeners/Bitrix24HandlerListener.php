<?php

namespace App\Listeners;

use App\Bitrix24\SaveLead;
use App\Events\CalcEvent;
use App\Events\CertificateOrderEvent;
use App\Events\OrderCallEvent;
use App\Events\OrderMiniEvent;
use App\Events\PickResponceEvent;
use App\Events\PickSubscriptionEvent;
use App\Events\PickTourEvent;
use App\Events\SendOrderTourEvent;

/**
 * Дублирует заявки с форм сайта в Битрикс24.
 *
 * Слушает те же события, что и почтовые обработчики, поэтому письма
 * продолжают уходить независимо от того, настроен Битрикс24 или нет.
 * Если интеграция выключена в админке — SaveLead молча ничего не делает.
 */
class Bitrix24HandlerListener
{
    public function handle(object $event): void
    {
        $request = $event->request;

        $lead = match (true) {
            $event instanceof OrderCallEvent => [
                'title' => 'Заказ звонка',
                'phone' => $request->phone,
                'fields' => [
                    'Город' => sity($request->sity),
                ],
            ],

            $event instanceof OrderMiniEvent => [
                'title' => 'Заявка с сайта',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ],

            $event instanceof PickTourEvent => [
                'title' => 'Подбор тура',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'fields' => [
                    'Страна' => $request->country,
                    'Даты' => $request->date,
                    'Город вылета' => sity($request->sity),
                ],
            ],

            $event instanceof CertificateOrderEvent => [
                'title' => 'Подарочный сертификат',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'fields' => [
                    'Сертификат' => $request->audience,
                    'Номинал' => $request->amount,
                ],
            ],

            $event instanceof PickSubscriptionEvent => [
                'title' => 'Подписка на туры',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'fields' => [
                    'Страна' => $request->country,
                    'Город вылета' => sity($request->sity),
                ],
            ],

            $event instanceof PickResponceEvent => [
                'title' => 'Отзыв с сайта',
                'name' => $request->name,
                'email' => $request->email,
                'fields' => [
                    'Отзыв' => $request->responce,
                ],
            ],

            $event instanceof SendOrderTourEvent => [
                'title' => 'Заказ тура',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'opportunity' => price_reverse($request->price),
                'fields' => [
                    'Тур' => $request->tourname,
                    'Отель' => $request->hotel,
                    'Страна' => $request->country,
                    'Город вылета' => sity($request->sity),
                    'Даты' => trim(($request->from ?? '') . ' — ' . ($request->to ?? ''), ' —'),
                    'Ночей' => $request->nights,
                    'Взрослых' => $request->adults,
                    'Детей' => $request->childs,
                    'Номер' => $request->room,
                    'Питание' => $request->mealrussian,
                    'Стоимость' => $request->price,
                ],
            ],

            $event instanceof CalcEvent => [
                'title' => 'Кредитный калькулятор',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'opportunity' => price_reverse($request->credit),
                'fields' => [
                    'Банк' => $request->bank,
                    'Сумма кредита' => $request->credit,
                    'Срок' => $request->term,
                    'Ставка' => $request->bet,
                    'Ежемесячный платёж' => $request->monthly_payment,
                    'Переплата' => $request->overpayment,
                    'Итого к выплате' => $request->total_payout,
                ],
            ],

            default => null,
        };

        if ($lead === null) {
            return;
        }

        $lead['name'] ??= '';
        $lead['url'] = $request->url;

        SaveLead::make()->save($lead);
    }
}
