@extends('layouts.viewport')
@section('viewport-content')
    <x-word-form action="{{route('words.store')}}">
    </x-word-form>
@endsection
