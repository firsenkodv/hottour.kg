@if(cart())
    <div class="cart_left">


        <div class="cart_left__myUrls">
            <a href="{{ route('cart_orders') }}"></a>
        </div>


        <x-forms.form-cart
            action="{{ route('cart_form') }}"
            method="POST"
        >
            <input type="submit" class="submit_cart" />
            <input type="hidden" name="tour_data" value="" class="tour_data" />

        </x-forms.form-cart>
    </div>
@endif


