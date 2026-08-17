@foreach($resorts as $item)
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
                </div>

                <div class="hcolImgText__smalltext colorGrey">
                    {!! $item->smalltext !!}
                </div>

            </div>

        </div>
    </div>

@endforeach
{{ $resorts->withQueryString()->links('pagination::default') }}

