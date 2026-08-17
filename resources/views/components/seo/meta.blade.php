@props([
    'title' => '',
    'description'=> '',
    'keywords' => '',
])

@section('title', ($title)?:null)
@section('description', ($description)?:null)
@section('keywords', ($keywords)?:null)
