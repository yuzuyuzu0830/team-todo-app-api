<?php

namespace Tests\Feature;

use App\Enums\TodoStatus;
use App\Models\Team;
use App\Models\User;
use App\Services\TodoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
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


    public function test_get_todo_list_excludes_other_team_todos()
    {
        // 別のチームとユーザーを作成
        $otherTeam = Team::factory()->create();
        $otherUser = User::factory()->create([
            'team_id' => $otherTeam->id
        ]);

        // 別のチームのTodoデータ
        $otherTeamTodo = [
            'id' => 3,
            'user_id' => $otherUser->id,
            'team_id' => $otherTeam->id,
            'title' => '他のチームのTodo',
            'completed' => TodoStatus::Pending->value
        ];

        // 現在のユーザーのチームのTodoデータ
        $expectedTodos = [
            [
                'id' => 1,
                'user_id' => $this->user->id,
                'team_id' => $this->team->id,
                'title' => 'テストTodo1',
                'completed' => TodoStatus::Pending->value
            ],
            [
                'id' => 2,
                'user_id' => $this->user->id,
                'team_id' => $this->team->id,
                'title' => 'テストTodo2',
                'completed' => TodoStatus::Completed->value
            ]
        ];

        // TodoServiceのモック設定
        $this->todoService->shouldReceive('getTodosForUser')
            ->once()
            ->with($this->team->id)
            ->andReturn($expectedTodos);

        $response = $this->actingAs($this->user)
            ->getJson("/api/todos/{$this->user->id}");

        $response->assertStatus(200)
            ->assertJson(['todos' => $expectedTodos])
            ->assertJsonMissing(['todos' => [$otherTeamTodo]]);
    }

    public function test_create_todo_successfully()
    {
        $todo = [
            'user_id' => $this->user->id,
            'team_id' => $this->user->team_id,
            'title' => "テストTodo"
        ];

        $this->todoService->shouldReceive('createTodo')
            ->once()
            ->with($todo);

        $response = $this->actingAs($this->user)
            ->postJson('/api/todos', $todo);

        $response->assertStatus(200)
            ->assertJson(['result' => 'ok']);
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
