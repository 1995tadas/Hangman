@extends('layouts.viewport')
@section('viewport-content')
    @auth()
        <a class="top-link" href="{{route('words.index')}}">Pridėti naujų žodžių</a>
    @else
        <a class="top-link" href="{{route('login')}}">Admin</a>
    @endauth
    @if($word)
        <game-component word="{{$word}}"></game-component>
    @else
        <div>Words database is empty!</div>
    @endif
@endsection
