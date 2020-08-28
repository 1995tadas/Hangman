<?php

namespace App\Http\Services;

class WordService
{

    public function wordLength($word)
    {
        return strlen($word);
    }

    public function redirectOrFail($ifTrue, $redirectRoute)
    {
        if ($ifTrue) {
            return redirect(route($redirectRoute));
        }
        return abort(404);
    }
}
