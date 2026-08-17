<div class="n_vid">
    <div class="n_vid__flex">

        <div class="n_vid__left">
            <div class="h2">{{ $main_category->title }}</div>
        </div>
        <div class="n_vid__right">
            <a href="{{ asset(config('links.link.dump') . '/' . $main_category->slug ) }}">{{ __('Посмотреть все') }}</a>
        </div>
    </div>

        <div class="n_vid__wrapper">
        <div class="n_vid__flex">

            @foreach($main_publs as $item)
            <div class="n_vid_item">
                <a href="{{ asset(config('links.link.dump').'/'. $main_category->slug).'/'.  $item->slug  }}" class="n_vid_item__link">
                    @if($item->img)
                        <img class="pc_category_img" width="260" height="160"
                             src="{{ asset(intervention('260x160', $item->img, 'dumps')) }}"
                             alt="{{$item->title}}">
                    @else
                        <div
                            style="
                            width: 260px;
                            height: 160px;
                            background-size: 70%;
                            background-color: #EF533F;
                            background-position: 28px 27px;
                            border-radius: 12px;
                            background-repeat: no-repeat;
                            background-image: url('{{ asset('images/inline/html-modals-gr-1.svg') }}');"
                        ></div>
                    @endif
                    <div class="n_vid_item__title">{{ $item->title }}</div>
                    <div class="n_vid_item__desc">{!! $item->smalltext !!}</div>
                </a>
            </div>
            @endforeach
        </div>
        </div>

</div><!--.n_vid-->



