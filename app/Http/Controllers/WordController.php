<?php

namespace App\Http\Controllers;

use App\Http\Requests\WordRequest;
use App\Word;

class WordController extends Controller
{
    public function store(WordRequest $request)
    {   $length = strlen($request->word);
        $word = Word::create([
            'word' => $request->word,
            'length' => $length
        ]);
    }
}
