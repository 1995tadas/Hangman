@extends('layouts.app')
@section('content')
    <div class="top-link">
        <a href="{{route('game.play')}}">
            <i class="fa fa-gamepad fa-2x" aria-hidden="true" title="{{__('game.game')}}"></i>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <i class="fas fa-sign-out-alt fa-2x" aria-hidden="true" title="{{__('auth.logout')}}"></i>
            </button>
        </form>
    </div>
    <div class="custom-container">
        <section class="words">
            <a class="admin-link" href="{{route('words.create')}}" title="{{__('words.add')}}">
                <i class="far fa-plus-square"></i>
            </a>
            @if(!$words->isEmpty())
                <words-component
                    :translation="{{json_encode(trans('words'))}}"
                    :words="{{$words}}"
                    edit-route="{{route('words.edit',['id' =>'/'])}}"
                    delete-route="{{route('words.destroy',['id' => '/'])}}">
                </words-component>
            @else
                <div>{{__('words.empty')}}</div>
            @endif
        </section>
    </div>
@endsection
