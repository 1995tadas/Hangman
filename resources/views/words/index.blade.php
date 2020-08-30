@extends('layout.app')
@section('content')
    <div class="custom-container">
        <section class="words">
            <a class="admin-link" href="{{route('words.create')}}">
                <i class="far fa-plus-square"></i>
            </a>
            @if(!$words->isEmpty())
                <expand-words-component :words="{{$words}}" edit-route="{{route('words.edit',['word' =>'/'])}}"
                                        delete-route="{{route('words.destroy',['word' => '/'])}}">
                </expand-words-component>
            @else
                <div>Empty</div>
            @endif
        </section>
    </div>
@endsection
