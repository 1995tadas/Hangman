@extends('layout.app')
@section('content')
    <div class="custom-container">
        <section class="words">
            @php
                $firstLetter = '';
            @endphp
            @forelse($words as $word)
                @if($firstLetter != $word->word[0])
                    <span class="first-letter">{{$firstLetter = $word->word[0]}}</span>
                @endif
                <span class="word">{{$word->word}}
                    <a class="edit-icon" href="{{route('words.edit',['word' => $word->id])}}">
                        <i class="fas fa-pencil-ruler"></i>
                    </a>
                </span>
            @empty
                <div>Empty</div>
            @endforelse
        </section>
    </div>
@endsection
