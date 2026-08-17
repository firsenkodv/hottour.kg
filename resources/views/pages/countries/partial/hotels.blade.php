@foreach($hotels as $item)
    <div class="hcol hcolImgText hcol__hotels">
        <div class="hcolImgText__flex flex">

            <div class="hcolImgText__left">
                <a href="{{ asset(route('countries').'/'. $country->slug. '/'. $hot_category->slug.'/'.$item->slug) }}">
                    @if($item->img)


                        <div  style="
                                            width: 199px;
                                            height: 199px;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            background-image: url('{{asset(intervention('199x199', $item->img))}}')">
                        </div>


                    @elseif($item->params)
                            @foreach($item->params as $img)
                                @if ($loop->first)
                                    <div  style="
                                            width: 199px;
                                            height: 199px;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            background-image: url('{{asset($img)}}')">
                                    </div>
                                @endif
                            @endforeach
                    @else
                        <div
                            style="
                            width: 199px;
                            height: 199px;
                            background-size: 70%;
                            background-color: #EF533F;
                            background-position: 28px 27px;
                            background-repeat: no-repeat;
                            background-image: url('{{ asset('images/inline/html-modals-gr-1.svg') }}');"

                        ></div>
                    @endif
                </a>
            </div>

            <div class="hcolImgText__right">

                <div class="hcolImgText__title">
                    <h2><a href="{{ asset(route('countries').'/'. $country->slug. '/'. $hot_category->slug.'/'.$item->slug) }}">{{ $item->title }}</a></h2>
                    @if($item->stars)
                        <div class="hotel__redstar">
                            <img width="15" height="15" loading="lazy" alt="hotel__redstar" src="{{ asset('images/inline/pages-countries-hotel-1.svg') }}">
                            <span>{{$item->stars}}</span>.0
                        </div>
                    @endif
                </div>

                <div class="hcolImgText__smalltext colorGrey">
                    {!! $item->desc !!}
                </div>

            </div>

        </div>
    </div>

@endforeach
{{ $hotels->withQueryString()->links('pagination::default') }}
