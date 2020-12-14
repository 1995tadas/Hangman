<?php

namespace Tests\Unit;

use Tests\TestCase;

class GameTest extends TestCase
{
    /** @test */
    public function check_if_game_play_works_and_have_required_variable()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(route('game.play'));
        $response->assertStatus(200);
        $response->assertViewHas('word');
    }
}
