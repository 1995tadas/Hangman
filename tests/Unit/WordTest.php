<?php

namespace Tests\Unit;

use App\Word;
use Illuminate\Support\Str;
use Tests\TestCase;

class WordTest extends TestCase
{

    /** @test */
    public function can_word_be_saved()
    {
        $wordFactory = factory(Word::class)->make();
        $response = $this->post(route('words.store'), [
            'word' => $wordFactory->word,
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function word_can_not_be_empty()
    {
        $response = $this->post(route('words.store'), [
            'word' => '',
        ]);
        $response->assertSessionHasErrors();

    }

    /** @test */
    public function word_can_not_be_duplicate()
    {
        $wordFactory = factory(Word::class)->make();
        for ($i = 0; $i <= 2; $i++) {
            $response = $this->post(route('words.store'), [
                'word' => $wordFactory->word,
            ]);
        }
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function word_can_not_be_not_string()
    {
        $response = $this->post(route('words.store'), [
            'word' => true,
        ]);
        $response->assertSessionHasErrors();
    }

    /** @test
     */
    public function word_can_not_be_longer_than_255_symbols()
    {
        $response = $this->post(route('words.store'), [
            'word' => Str::random(256)
        ]);
        $response->assertSessionHasErrors();
    }
}
