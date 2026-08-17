<div class="s_dep js-chosen-background-img s_block__2">
    <div class="s_dep__label s_label">{{__('Направление')}}</div>
    <select name="country" class="js-chosen js-country-select ">
        <optgroup label="ПОПУЛЯРНЫЕ">
            @foreach($countries['popular'] as $country)
                <option style="background-image: url({{ asset('/images/flags/'.$api->getFlag($country['flag']).'.svg')}}); background-repeat: no-repeat; background-position: 5px;" value="{{ $country['country_id']}}"

                @if(!empty($country['default'])) {{'selected'}}@endif>
                    {{ $country['name']}}</option>
            @endforeach
        </optgroup>
        <optgroup label="ОСТАЛЬНЫЕ">

            @foreach($countries['other'] as $country)
                <option style="background-image: url({{ asset('/images/flags/'.$api->getFlag($country['flag']).'.svg')}}); background-repeat: no-repeat; background-position: 5px;" value=" {{$country['country_id']}}"
                @if(!empty($country['default'])) {{ 'selected' }}@endif>
                    {{$country['name']}}</option>
            @endforeach
        </optgroup>
    </select>

</div>

