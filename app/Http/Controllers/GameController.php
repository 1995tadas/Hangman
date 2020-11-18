<?php

namespace App\Http\Controllers;

use App\Word;

class GameController extends Controller
{

    public function play()
    {
        $word = false;
        if (Word::count() != 0) {
            $word = Word::inRandomOrder()->first('word')->word;
        }

        return view('games.play', ['word' => $word]);
    }
}
