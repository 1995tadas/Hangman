<?php

namespace Tests\Unit;

use App\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class WordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_word_be_saved()
    {
        $wordFactory = factory(Word::class)->make();
        $response = $this->post(route('words.store'), [
            'word' => $wordFactory->word,
        ]);
        $response->assertStatus(302);
    }

    /** @test */
    public function can_word_be_updated()
    {
        $wordFactoryCreate = factory(Word::class)->create();
        $wordFactoryUpdate = factory(Word::class)->make();
        $response = $this->put(route('words.update', ['id' => $wordFactoryCreate->id]), [
            'word' => $wordFactoryUpdate->word,
        ]);
        $response->assertStatus(302);
    }

    /** @test */
    public function can_word_be_deleted()
    {   $this->withoutExceptionHandling();
        $wordFactoryCreate = factory(Word::class)->create();
        $response = $this->delete(route('words.destroy', ['word' => $wordFactoryCreate->id]));
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

    /** @test */
    public function word_can_not_be_shorter_than_2_symbols()
    {
        $response = $this->post(route('words.store'), [
            'word' => Str::random(1)
        ]);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function word_can_not_be_longer_than_255_symbols()
    {
        $response = $this->post(route('words.store'), [
            'word' => Str::random(256)
        ]);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function word_can_not_contain_spaces()
    {
        $response = $this->post(route('words.store'), [
            'word' => 'test test'
        ]);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function does_create_route_works()
    {
        $response = $this->get(route('words.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function does_index_have_words()
    {
        $response = $this->get(route('words.index'));
        $response->assertStatus(200);
        $response->assertViewHas('words');
    }

    /** @test */
    public function does_edit_have_word()
    {
        $wordFactory = factory(Word::class)->create();
        $response = $this->get(route('words.edit', ['word' => $wordFactory->id]));
        $response->assertStatus(200);
        $response->assertViewHas('word');
    }

    /** @test */
    public function does_edit_word_id_parameter_valid()
    {
        $wordFactory = factory(Word::class)->make();
        $response = $this->get(route('words.edit', ['word' => $wordFactory->word]));
        $response->assertStatus(404);
    }

    /** @test */
    public function does_edit_id_parameter_do_exist()
    {
        $wordFactory = factory(Word::class)->create();
        $wordFactory->delete();
        $response = $this->get(route('words.edit', ['word' => $wordFactory->id]));
        $response->assertStatus(404);
    }

    /** @test */
    public function does_update_word_id_parameter_valid()
    {
        $wordFactory = factory(Word::class)->make();
        $response = $this->put(route('words.edit', ['word' => $wordFactory->word]), [
            'word' => $wordFactory->word
        ]);
        $response->assertStatus(404);
    }

    /** @test */
    public function does_destroy_word_id_parameter_valid()
    {
        $wordFactory = factory(Word::class)->make();
        $response = $this->delete(route('words.destroy', ['word' => $wordFactory->word]));
        $response->assertStatus(404);
    }
    /** @test */
    public function does_destroy_id_parameter_do_exist()
    {
        $wordFactory = factory(Word::class)->create();
        $wordFactory->delete();
        $response = $this->delete(route('words.destroy', ['word' => $wordFactory->id]));
        $response->assertStatus(404);
    }
}
