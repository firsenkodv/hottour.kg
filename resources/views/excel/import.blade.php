@extends('layouts.layout')
@section('content')
    <main>
        <section class="block countries height_100">
            <div class="page_site__flex height_100">
<div class="page_site__left">

    <div class="hbox temp_img">
        <div class="hbox__top pad_b1">
            <h1>{{__('Import Data')}}</h1>
        </div>

    </div>
<div class="hbox__middle country_page">

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('import') }}" class="w_300_px pad_b30" method="post" enctype="multipart/form-data">
        @csrf

        <div class="text_input pad_b19">
            <x-forms.file
                accept=".xlsx, .csv"
                required="required"
                name="import_file"
            >
                <span class="input-file-btn">Upload File</span>
                <span class="input-file-text">Max 10Mb</span>
            </x-forms.file>

        </div>

        <x-forms.button class="button_normal">Import Data</x-forms.button>


        {{--<button class="button button_big" type="submit">Import Data</button>--}}
    </form>


</div>

</div>
<div class="page_site__right"></div>
            </div>


        </section>

    </main>
@endsection
