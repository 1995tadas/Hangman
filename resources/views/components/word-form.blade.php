<div class="top-link">
    <a href="{{route('words.index')}}" title="{{__('words.everything')}}">
        <i class="fas fa-arrow-alt-circle-left fa-2x"></i>
    </a>
</div>
<div class="form-container">
    <form class="word-form" autocomplete="off" action="{{$action}}" method="post">
        {{ $slot }}
        @csrf
        <input class="word-input" type="text" name="word" @if($value) value="{{$value}}" @endif maxlength="255"
               autofocus required autocapitalize="characters">
        <input class="word-submit" type="submit" value="{{$buttonValue}}">
    </form>
    @error('word')
    <div class="error">
        {{$message}}
    </div>
    @enderror
    @if( Session::has( 'success' ))
        <span class="success">
            @if(Session::has( 'word' ))
                <span class="success-word">
                {{ Session::get( 'word' ) }}
                </span>
            @endif
            {{ Session::get( 'success' ) }}
            @if(Session::has( 'word_id' ))
                <a href="{{route('words.edit', ['id' => Session::get( 'word_id' )])}}"
                   title="{{__('words.edit')}}" class="success-edit">
                    <i class="fas fa-pencil-ruler"></i>
                </a>
                <form class="success-form" action="{{route('words.destroy', ['id' => Session::get( 'word_id' )])}}"
                      method="post">
                @csrf
                    @method('delete')
                <button title="{{__('words.delete')}}" class="success-button">
                    <i class="far fa-trash-alt"></i>
                </button>
                </form>
            @endif
        </span>
    @endif
</div>
