@extends('layout.app')
@section('content')
    <x-word-form action="{{route('words.store')}}" method="post">
        @csrf
    </x-word-form>
@endsection
