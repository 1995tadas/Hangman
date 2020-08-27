@extends('layout.app')
@section('content')
    <x-word-form action="{{route('words.update',['word' => $word->id])}}" method="put">
        @csrf
    </x-word-form>
@endsection
