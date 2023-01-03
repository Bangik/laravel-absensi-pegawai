<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PresentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function present_page_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/home')->assertStatus(200);
    }

    /** @test */
    public function user_can_present()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/absen', [
            'user_id' => $user->id,
        ])->assertRedirect('/');
    }
}
