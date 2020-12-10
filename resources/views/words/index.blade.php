@extends('layouts.app')
@section('content')
    @auth()
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="top-link" type="submit">Atsijungti</button>
        </form>
    @endauth
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
