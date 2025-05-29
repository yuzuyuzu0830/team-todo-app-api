<?php

namespace Tests\Feature;

use App\Enums\TodoStatus;
use App\Models\Team;
use App\Models\Todo;
use App\Models\User;
use App\Services\TodoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    protected Team $team;
    protected User $user;
    protected $todoService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create team
        $this->team = Team::factory()->create();

        // Create user
        $this->user = User::factory()->create([
            'team_id' => $this->team->id
        ]);

        // Mock TodoService
        $this->todoService = Mockery::mock(TodoService::class);
        $this->app->instance(TodoService::class, $this->todoService);
    }

    public function test_create_todo_successfully()
    {
        $todo = [
            'user_id' => $this->user->id,
            'team_id' => $this->user->team_id,
            'title' => "テストTodo"
        ];

        $expectedResponse = array_merge(
            $todo,
            [
                'id' => 1,
                'completed' => TodoStatus::Pending->value
            ]);
        
        $this->todoService->shouldReceive('createTodo')
            ->once()
            ->with($todo)
            ->andReturn($expectedResponse);

        $response = $this->actingAs($this->user)
            ->postJson('/api/todos', $todo);

        $response->assertStatus(200)
            ->assertJson($expectedResponse);
    }

    public function test_create_todo_with_wrong_format()
    {
        $todo = [
            'user_id' => $this->user->id,
            'team_id' => $this->user->team_id,
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/todos', $todo);
        
        $response->assertStatus(422)
            ->assertJson([
                'message' => 'タイトルは必須です',
                'errors' => [
                    'title' => ['タイトルは必須です']
                ]
            ]);
    }
}
