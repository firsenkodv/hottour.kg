@props([
     'name'   =>  'import_file',
     'min' =>  '',
     'required' =>  '',
     'accept' =>  '.xlsx, .csv',

])

<label class="input-file">
    <input type="file" name="{{$name}}" accept="{{$accept}}" {{$required}}>
    {{ $slot }}
</label>
