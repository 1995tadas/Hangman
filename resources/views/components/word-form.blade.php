<form  class="form-container" action="{{$action}}" method="{{$method}}">
    {{ $slot }}
    <input type="text" name="word" maxlength="255" autofocus required autocapitalize="characters">
    <input type="submit">
</form>
