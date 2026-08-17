<div class="s_sity s_block__1">
    <div class="s_sity__label s_label">{{__('Город вылета')}}</div>
    <select class="js-chosen" name="departure" placeholder="Выберите город">
        <optgroup label="ПОПУЛЯРНЫЕ">
            @foreach($departures['popular'] as $departure)
                <option value="{{$departure['id']}}"
                @if(!empty($departure['default'])) {{'selected'}}@endif>
                        <?php echo $departure['name']?></option>
            @endforeach
        </optgroup>
        <optgroup label="ОСТАЛЬНЫЕ">
            @foreach($departures['other'] as $departure)
                <option value="{{$departure['id']}}"
                @if(!empty($departure['default'])) {{'selected'}}@endif>
                    {{ $departure['name']}}</option>
            @endforeach

        </optgroup>
    </select>
</div>
