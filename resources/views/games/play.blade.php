@extends('layout.app')
@section('content')
    <div class="viewport-container">
        @if($word)
            <game-component :letters='@json(str_split($word))'></game-component>
        @else
            <div>Words database is empty!</div>
        @endif
    </div>
@endsection
