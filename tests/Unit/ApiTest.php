<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

     public function test_it_can_create_a_post()
     {
         $this->withoutMiddleware();
 
         $data = [
             'name' => 'test',
             'email' => 'local@gmail.com',
             'password' => '123456',
         ];
 
         $response = $this->post('/api/users', $data);
         $response->assertStatus(200);
 
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
 
         $response = $this->put('/api/users/' . $user->id, $data);
         $response->assertStatus(200);
 
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
 
         $response = $this->delete('/api/users/' . $user->id);
         $response->assertStatus(200);
         $this->assertDatabaseMissing('users', ['id' => $user->id]);
     }
 
     /** @test */
     public function test_it_can_get_all_a_post()
     {
         $this->withoutMiddleware();
         $user = User::factory()->create();
 
         $response = $this->get('/api/users');
         $response->assertStatus(200);
 
         $response->assertJsonFragment([
             'name' => $user->name,
             'email' => $user->email,
         ]);
     }
 
     /** @test */
     public function test_it_can_login_a_post()
     {
         $this->withoutMiddleware();
         $user = User::factory()->create();
 
         $data = [
             'email' => $user->email,
             'password' => '123456',
         ];
 
         $response = $this->post('/api/login', $data);
         $response->assertStatus(401);
     }

     /** @test */
     public function test_it_can_insert_batch_a_post()
     {
         $this->withoutMiddleware();
         $data = [
             'user' => [
                [
                    'name' => 'test 1',
                    'email' => 'local@gmail.com',
                    'password' => '123456',
                ],
                [
                    'name' => 'test 2',
                    'email' => 'local2@gmail.com',
                    'password' => '123456',
                ],
             ]
         ];
 
         $response = $this->post('/api/users/insert_batch/', $data);
         $response->assertStatus(500);
     }
    }
