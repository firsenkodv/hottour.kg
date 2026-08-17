@if(count($contracts))
<div class="dashboardBox pad_t29">

    <div class="dashboardBox__title">
        <div class="a_user__row a_user">
            <div class="a_user__name">
                {{ __('Договор') }}
            </div>
            <div class="a_user__email">
                {{ __('Даты, дней') }}
            </div>
            <div class="a_user__flex_direction">
                {{ __('Стоимость') }}
            </div>
            <div class="a_user__flex_direction">
                {{ __('Статус') }}
            </div>
        </div>
    </div>

    <div class="dashboardBox__a_users a_users pad_b26">
        @foreach($contracts as $contract)
            <div class="a_user__row a_user user-contract-row-click {{ $contract->is_signed ? 'background_green' : 'background_alert' }}" data-url="{{ $contract->public_url }}" style="cursor:pointer;">
                <div class="a_user__name">
                    <div class="a_user__nameFio">
                        <div class="a_user__left">Дог. {{ $contract->contract_number }}</div>
                    </div>
                    <div class="a_user__nameBirthdate color_grey color_grey_12">
                        @if($contract->city_departure || $contract->city_arrival)
                            {{ $contract->city_departure }} — {{ $contract->city_arrival }}
                        @endif
                    </div>
                </div>
                <div class="a_user__email">
                    <div class="a_user__nameFio">
                        {{ $contract->date_departure?->format('d.m.Y') }} — {{ $contract->date_arrival?->format('d.m.Y') }}
                    </div>
                    <div class="a_user__nameBirthdate color_grey color_grey_12">
                        {{ $contract->days_count }} {{ __('дн.') }}
                    </div>
                </div>
                <div class="a_user__flex_direction">
                    <div>{{ price($contract->tour_price) }} {{ config('currency.currency.KZT') }}</div>
                </div>
                <div class="a_user__flex_direction">
                    @if($contract->is_signed)
                        <span class="contract-status contract-status--signed">Подписан</span>
                    @else
                        <span class="contract-status contract-status--pending">Ожидает</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
{{ $contracts->withQueryString()->links('pagination::default') }}
@else
<div class="dashboardBox pad_t29 pad_b26">
    <div class="a_user__row" style="justify-content:center; color:#888; padding: 24px 0;">
        {{ __('У вас пока нет договоров.') }}
    </div>
</div>
@endif
