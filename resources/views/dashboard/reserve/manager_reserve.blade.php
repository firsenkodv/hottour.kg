@php
$manager = [];
    if($item->manager) {
        $manager = $item->manager;
    } else {
        $manager = manager_reserve();

    }
@endphp
<div class="cabiten_leftBar__YourManeger whiteBox blockYourManeger">
    <div>
        <div class="blockYourManeger__top">
            <div class="blockYourManeger__top_left">
                                <span>

                                    <div class="site_avatar"
                                         style="background-image: url('@if($manager->avatar) {{ Storage::disk('user')->url($manager->avatar) }} @else {{ asset('images/inline/dashboard-left-bar-avatar-1.svg') }} @endif '); width: 48px; height: 48px"></div>


                                </span>
            </div>
            <div class="blockYourManeger__top_right">
                <div class="blockYourManeger__name font_black font_black_16_600">
                    @if(isset($manager->connection->title) and $manager->connection->title != "")
                        {{ $manager->connection->title}}
                    @else
                        {{$manager->name}}
                    @endif

                </div>
                <div
                    class="blockYourManeger__text color_grey color_grey_14 ">{{ __('Ваш персональный менеджер') }}</div>
            </div>

        </div>
        <div class="blockYourManeger__line"></div>
        <div class="blockYourManeger__bottom">

            <div class="blockYourManeger__bottom_flex">
                <div class="blockYourManeger__bottom_left">
                    <div class="blockYourManeger__bottom_imgPhone">
                        <img alt="phone" width="24" height="24"
                             src="{{ asset('images/inline/dashboard-reserve-manager-reserve-1.svg') }}">
                    </div>
                    <div class="blockYourManeger__bottom_numPhone">
                        <a href="tel:{{(isset($manager->connection->phone) and $manager->connection->phone !="")?$manager->connection->phone:$manager->phone}}">{{(isset($manager->connection->phone)  and $manager->connection->phone !="")?format_phone($manager->connection->phone):format_phone($manager->phone)}}</a>
                    </div>

                </div>
                <div class="blockYourManeger__bottom_right">
                    @if(isset($manager->connection->whatsapp)  and $manager->connection->whatsapp !="")
                        <a href="https://wa.me/{{ $manager->connection->whatsapp }}" target="_blank">
                            <img alt="wa" width="24" height="24"
                                 src="{{ asset('images/inline/dashboard-reserve-manager-reserve-2.svg') }}">
                        </a>
                    @endif
                    @if(isset($manager->connection->telegram) and $manager->connection->telegram !="")
                        <a href="{{$manager->connection->telegram}}" target="_blank">
                            <img alt="telegram" width="24" height="24"
                                 src="{{ asset('images/inline/dashboard-reserve-manager-reserve-3.svg') }}"></a>
                    @endif
                </div>

            </div>
            <div class="blockYourManeger__bottom_flex">
                <div class="blockYourManeger__bottom_left">
                    <div class="blockYourManeger__bottom_imgPhone">
                        <img alt="email" width="22" height="19"
                             src="{{ asset('images/inline/dashboard-reserve-manager-reserve-4.svg') }}">
                    </div>
                    <div
                        class="blockYourManeger__bottom_numPhone">{{(isset($manager->connection->email) and $manager->connection->email !="")?$manager->connection->email:$manager->email}}</div>
                </div>
                <div class="blockYourManeger__bottom_right"></div>
            </div>
        </div>
    </div>
</div>
