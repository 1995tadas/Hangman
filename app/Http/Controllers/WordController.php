<?php

namespace App\Http\Controllers;

use App\Http\Requests\WordRequest;
use App\Word;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all(['word', 'id'])->sortBy('word');
        return view('words.index', compact('words'));
    }

    public function store(WordRequest $request)
    {
        $length = strlen($request->word);
        $word = Word::create([
            'word' => $request->word,
            'length' => $length
        ]);
        if ($word) {
            return redirect(route('words.index'));
        }
    }

    public function edit(Word $word)
    {
        return view('words.edit', compact('word'));
    }

    public function update(WordRequest $request)
    {
        dd($request);
    }
}
