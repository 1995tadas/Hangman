<?php

namespace Tests\Unit;

use Tests\TestCase;

class GameTest extends TestCase
{
    /** @test */
    public function check_if_select_redirection_works()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(route('games.select'));
        $response->assertStatus(200);
    }
}
