@extends('layouts.viewport')
@section('viewport-content')
    <x-word-form action="{{route('words.store')}}" buttonValue="{{__('words.create')}}">
    </x-word-form>
@endsection
