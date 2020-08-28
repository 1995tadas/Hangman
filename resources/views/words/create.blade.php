@extends('layout.app')
@section('content')
    <x-word-form action="{{route('words.store')}}">
    </x-word-form>
@endsection
