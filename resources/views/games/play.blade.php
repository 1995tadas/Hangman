@extends('layouts.viewport')
@section('viewport-content')
    <div class="top-link">
        @auth()
            <a href="{{route('words.index')}}" title="{{__('words.add_many')}}">
                <i class="fas fa-list fa-2x"></i>
            </a>
        @else
            <a title="{{__('auth.admin')}}" href="{{route('login')}}">
                <i class="fas fa-user-shield fa-2x"></i>
            </a>
        @endauth
    </div>
    @if($word)
        <game-component word="{{$word}}" :translation="{{json_encode(trans('games'))}}"></game-component>
    @else
        <h1 class="data-empty">{{__('words.empty')}}</h1>
    @endif
@endsection
