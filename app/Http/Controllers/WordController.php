<?php

namespace App\Http\Controllers;

use App\Http\Requests\WordRequest;
use App\Http\Services\WordService;
use App\Word;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all(['word', 'id'])->sortBy('word')->values();
        return view('words.index', compact('words'));
    }

    public function store(WordRequest $request)
    {
        $wordService = new WordService();
        $word = Word::create([
            'word' => strtolower($request->word),
        ]);
        return $wordService->redirectOrFail($word, 'words.index');
    }

    public function edit(Word $word)
    {
        return view('words.edit', compact('word'));
    }

    public function update(WordRequest $request, $id)
    {
        $wordService = new WordService();
        $wordModel = new Word;
        $word = $wordModel->findOrFail($id)->update([
            'word' => strtolower($request->word),
        ]);
        return $wordService->redirectOrFail($word, 'words.index');
    }

    public function destroy(Word $word)
    {
        try {
            return $word->delete();
        } catch (\Exception $e) {
            return $e;
        }
    }
}
