<div class="search_hotel_form F_form sticky">
    <div class="search_hotel_form__wrapper hotel__dataorder">

        <x-forms.loader class="br_12"/>

    <div class="search_hotel_form__form">

        <div class="search_hotel_form__price"><span class="__price_js"></span> <span  class="__currency __currency_js"></span></div>
        <div class="search_hotel_form__location sity_up__label">{{__('Город вылета')}}</div>
        <div class="sity_up __sity_js"></div>
        <div class="search_hotel_form__location">{{__('Отель')}}</div>
        <div class="hotel_down __hotel_js"></div>
        <div class="search_hotel_form__dates">

            <div class="search_hotel_form__datesLeft m_dd">
                <div class="m_dd__dateLabel"><span>Дата вылета</span></div>
                <div class="m_dd__date "><span class="__flydate_js"></span></div>
            </div>

            <div class="search_hotel_form__datesRight m_dd">
                <div class="m_dd__dateLabel"><span>Ночей</span></div>
                <div class="m_dd__date"><span class="__nights_js"></span></div>
            </div>

        </div>

        <div class="search_hotel_form__location meat_up__label">{{__('Питание')}}</div>
        <div class="meat_down"><span class="__meal_js"></span> <span class="__mealrussian_js"></span></div>

        <a href="#reserve_hotel" data-fancybox class="button button_big tour_button_js" data-tout_data="">{{__('Забронировать')}}</a>
        <div  class="search_hotel_form__location text_center pad_t7_important" >{{__('За бронирование вы ничего не платите')}}</div>


    </div>

</div>
</div>
