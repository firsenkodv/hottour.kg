<li data-option="" class="select__item">--</li>
@foreach(config('selects.data_sity') as $key => $city)
    <li data-option="{{ $city['value'] }}" class="select__item">{{ $city['text'] }}</li>
@endforeach
