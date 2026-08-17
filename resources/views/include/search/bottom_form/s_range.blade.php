<div class="s_bottomright__middle s_sb">

    <div class="s_range">
        <div class="range">

            <div class="range-price">
                <label for="min"></label>
                <input type="text" name="pricefrom" value="{{price(50000)}}">
                <label for="max"></label>
                <input type="text" name="priceto" value="{{price(1000000)}}">
            </div>

            <div class="range-slider">
                <span class="range-selected"></span>
            </div>

            <div class="range-input">
                <input type="range" class="min" min="0" max="10000000" value="50000" step="1000">
                <input type="range" class="max" min="0" max="10000000" value="1000000" step="1000">
            </div>

        </div>
    </div>

    <div class="s_rating">
        <div class="s_rating__label  s_label">{{ __('Рейтинг') }}</div>
        <div class="s_rating__data">
            <div class="s_rating__label active s_rating_1" data-hotelrating="1">{{ __('Любой') }}</div>
            <div class="s_rating__label s_rating_2" data-hotelrating="3">+3</div>
            <div class="s_rating__label s_rating_3" data-hotelrating="3.5">+3,5</div>
            <div class="s_rating__label s_rating_4" data-hotelrating="4">+4</div>
            <div class="s_rating__label s_rating_5" data-hotelrating="4.5">+4,5</div>
        </div>
    </div>
</div>

