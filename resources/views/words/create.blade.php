@extends('layouts.viewport')
@section('viewport-content')
    <x-word-form action="{{route('words.store')}}"
                 buttonValue="{{__('words.create')}}"
                 value="{{old('word')}}">
    </x-word-form>
@endsection
