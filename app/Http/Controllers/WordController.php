<?php

namespace App\Http\Controllers;

use App\Http\Requests\WordRequest;
use App\Http\Services\ErrorService;
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
        $word = Word::create([
            'word' => strtolower($request->word),
        ]);
        $errorService = new ErrorService();
        return $errorService->redirectOrFail($word, 'words.create')
            ->with('success', '' . __('words.created'))
            ->with('word', $word->word)
            ->with('word_id', $word->id);
    }

    public function edit(Word $id)
    {
        return view('words.edit', ['word' => $id]);
    }

    public function update(WordRequest $request, Word $id)
    {
        $word = $id;
        $updated = $word->update([
            'word' => strtolower($request->word),
        ]);
        if ($updated) {
            $errorService = new ErrorService();
            return $errorService->redirectOrFail($word, 'words.create')
                ->with('success', ' ' . __('words.edited'))
                ->with('word', $word->word)
                ->with('word_id', $word->id);
        }

        abort(404);
    }

    public function destroy(Word $id)
    {

        try {
            $deleted = $id->delete();
            if ($deleted) {
                if (request()->wantsJson()) {
                    return response()->json($deleted);
                }

                return redirect(route('words.create'))
                    ->with('success', __('words.deleted'));
            }

            abort(404);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
