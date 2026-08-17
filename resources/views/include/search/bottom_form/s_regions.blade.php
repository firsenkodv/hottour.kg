<div class="checkbox_choice region_ch">
    <div class="checkbox_choice__name">
        <div class="checkbox_choice__name__flex flex">
            <span>Курорт</span>
            <label for="any-region"><input class="any_checkbox" checked id="any-region" type="checkbox"> Любой</label>
        </div>
    </div>
    <div class="scroll-block" id="regions-area">
        @foreach($regions as $region)
        <label class="checkbox_choice__item">
            <input class="region_checkbox" type="checkbox" name="region[]" value="{{$region->id }}" data-title="{{ $region->name }}">
            <span>{{ $region->name }}</span>
        </label>
        @endforeach
    </div>
</div>
