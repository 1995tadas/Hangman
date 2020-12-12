<?php

namespace App\Http\Services;

class ErrorService
{
    public function redirectOrFail(object $ifTrue, string $redirectRoute, int $message = 404): object
    {
        if ($ifTrue) {
            return redirect(route($redirectRoute));
        }

        abort($message);
    }
}
