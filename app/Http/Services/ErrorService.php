<?php

namespace App\Http\Services;

class ErrorService
{
    public function redirectOrFail(object $ifTrue, string $redirectRoute, array $parameters = [], int $message = 404): object
    {
        if ($ifTrue) {
            return redirect(route($redirectRoute, $parameters));
        }

        abort($message);
    }
}
