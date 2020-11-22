@extends('layouts.viewport')
@section('viewport-content')
    <x-word-form action="{{route('words.update',['id' => $word->id]) }}" value="{{$word->word}}">
        @method('put')
    </x-word-form>
@endsection
