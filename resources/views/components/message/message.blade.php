@if($message = flash()->get())
    <div class="{{ $message->class() }} flashMassege">
        <div class="flashMassege__relative">
            <div class="flashMassege__close flashClose__js"></div>
        {!! $message->message() !!}
        </div>
    </div>
@endif



