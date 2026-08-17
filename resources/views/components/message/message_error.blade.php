@if ($errors->any())
    <div class="class__alert flashMassege">
        <div class="flashMassege__relative">
            <div class="flashMassege__close flashClose__js"></div>
            {!!  config('message_flash.alert.h2error') !!}
        @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
        @endforeach

        </div>
    </div>
@endif
