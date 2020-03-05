<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** 
     * It will show all user
     * @test
     */
    public function index()
    {
        $tasks = factory(User::class, 10)->create();

        $response = $this->get(route('api.users'));

        $response->assertStatus(200);

        $response->assertJson($tasks->toArray());
    }

    /** 
     * It will show currenct user 
     * @test 
     */
    public function show()
    {
        $this->post(route('api.user.create'), [
            'title'       => 'This is a title',
            'description' => 'This is a description'
        ]);
        
        $user = User::all()->first();

        $response = $this->get(route('api.user.show', $user));

        $response->assertStatus(200);

        $response->assertJson([
            'code' => 200,
            'status' => 'success',
            'data' => $user->toArray()
        ]);

        $response->dumpHeaders();

        $response->dump();
    }

    /** 
     * It will create user
     * @test
     */
    public function store()
    {
        $response = $this->post(route('api.user.create'), [
            'title'       => 'This is a title',
            'description' => 'This is a description'
        ]);
        

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'title' => 'This is a title'
        ]);

        $response->assertJsonStructure([
            'code',
            'status',
            'data' => [
                'updated_at',
                'created_at',
                'id'
            ]
        ]);
    }
        
    /** 
     * It will update user
     * @test
     */
    public function update()
    {
        $this->post(route('api.user.create'), [
            'title'       => 'This is a title',
            'description' => 'This is a description'
        ]);

        $user = User::all()->first();

        $response = $this->put(route('api.user.edit', $user), [
            'title' => 'This is the updated title'
        ]);
        
        $response->assertStatus(200);

        $user = $user->fresh();
        
        $this->assertEquals($user->title, 'This is the updated title');

        $response->assertJsonStructure([
            'code',
            'status',
            'data' => [
                'updated_at',
                'created_at',
                'id'
            ]
        ]);
    }

    /** 
     * It will delete user
     * @test 
     */
    public function delete()
    {
        $this->post(route('api.user.create'), [
            'title'       => 'This is a title',
            'description' => 'This is a description'
        ]);

        $user = User::all()->first();

        $response = $this->delete(route('api.user.delete', $user));

        $user = $user->fresh();

        $this->assertNull($user);

        $response->assertJson([
            'code' => 200,
            'status' => 'success',
        ]);
    }
}
