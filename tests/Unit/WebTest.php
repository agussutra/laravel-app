<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WebTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function test_it_can_create_a_post()
    {
        $this->withoutMiddleware();

        $data = [
            'name' => 'test',
            'email' => 'local@gmail.com',
            'password' => '123456',
        ];

        $response = $this->post('/users', $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'local@gmail.com',
        ]);
    }

    /** @test */
    public function test_it_can_update_a_post()
    {
        $this->withoutMiddleware();

        $user = User::factory()->create();

        $data = [
            'name' => 'test 1',
            'email' => 'local@gmail.com',
            'password' => '123456',
        ];

        $response = $this->put('/users/' . $user->id, $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'test 1',
            'email' => 'local@gmail.com',
        ]);
    }

    /** @test */
    public function test_it_can_delete_a_post()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();

        $response = $this->delete('/users/' . $user->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
