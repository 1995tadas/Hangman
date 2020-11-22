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
            <a class="admin-link" href="{{route('words.create')}}">
                <i class="far fa-plus-square"></i>
            </a>
            @if(!$words->isEmpty())
                <expand-words-component
                    :words="{{$words}}"
                    edit-route="{{route('words.edit',['id' =>'/'])}}"
                    delete-route="{{route('words.destroy',['id' => '/'])}}">
                </expand-words-component>
            @else
                <div>Empty</div>
            @endif
        </section>
    </div>
@endsection
