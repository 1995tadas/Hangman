<form class="form-container" action="{{$action}}" method="post">
    {{ $slot }}
    @csrf
    <input type="text" name="word" @if($value) value="{{$value}}" @endif maxlength="255" autofocus required autocapitalize="characters">
    @error('word')
        <div class="error-text">{{ $message }}</div>
    @enderror
    <input type="submit">
</form>
