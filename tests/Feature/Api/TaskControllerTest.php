<?php

declare(strict_types = 1);

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_index_returns_only_user_tasks(): void
    {
        Task::factory()->count(3)->for($this->user)->create();
        Task::factory()->count(2)->for(User::query()->find(2))->create(); // Tasks for another user

        $this->getJson(route('api.tasks.index'))
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_store_creates_new_task(): void
    {
        $taskData = [
            'title'       => 'New API Task',
            'description' => 'Description for the new task.',
            'status'      => 'pendente',
        ];

        $this->postJson(route('api.tasks.store'), $taskData)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment(['title' => 'New API Task']);

        $this->assertDatabaseHas('tasks', [
            'title'   => 'New API Task',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_store_fails_with_validation_error(): void
    {
        $this->postJson(route('api.tasks.store'), ['title' => ''])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('title');
    }

    public function test_show_returns_correct_task(): void
    {
        $task = Task::factory()->for($this->user)->create();

        $this->getJson(route('api.tasks.show', $task))
            ->assertOk()
            ->assertJsonFragment(['id' => $task->id]);
    }

    public function test_show_fails_for_another_users_task(): void
    {
        $task = Task::factory()->for(User::query()->find(2))->create(); // Belongs to another user

        $this->getJson(route('api.tasks.show', $task))
            ->assertForbidden();
    }

    public function test_update_modifies_task(): void
    {
        $task = Task::factory()->for($this->user)->create();
        $updateData = ['title' => 'Updated Title'];

        $this->putJson(route('api.tasks.update', $task), $updateData)
            ->assertOk()
            ->assertJsonFragment(['title' => 'Updated Title']);

        $this->assertDatabaseHas('tasks', [
            'id'    => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_update_fails_for_another_users_task(): void
    {
        $task = Task::factory()->create();

        $this->putJson(route('api.tasks.update', $task), ['title' => 'fail'])
            ->assertForbidden();
    }

    public function test_toggle_status_changes_task_status(): void
    {
        $task = Task::factory()->for($this->user)->create(['status' => 'pendente']);

        $this->patchJson(route('api.tasks.toggle-status', $task))
            ->assertOk()
            ->assertJsonFragment(['status' => 'concluída']);

        $this->assertEquals('concluída', $task->fresh()->status);

        $this->patchJson(route('api.tasks.toggle-status', $task))
            ->assertOk()
            ->assertJsonFragment(['status' => 'pendente']);

        $this->assertEquals('pendente', $task->fresh()->status);
    }

    public function test_toggle_status_fails_for_another_users_task(): void
    {
        $task = Task::factory()->create();

        $this->patchJson(route('api.tasks.toggle-status', $task))
            ->assertForbidden();
    }

    public function test_destroy_deletes_task(): void
    {
        $task = Task::factory()->for($this->user)->create();

        $this->deleteJson(route('api.tasks.destroy', $task))
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    public function test_destroy_fails_for_another_users_task(): void
    {
        $task = Task::factory()->create();

        $this->deleteJson(route('api.tasks.destroy', $task))
            ->assertForbidden();
    }

    /**
     * @dataProvider protectedApiRoutes
     */
    public function test_unauthenticated_user_cannot_access_endpoints(string $method, string $route): void
    {
        Sanctum::actingAs(User::factory()->create(), [], ''); // Unset the current user

        $this->json($method, route($route, ['task' => 1]))
            ->assertUnauthorized();
    }

    public static function protectedApiRoutes(): array
    {
        return [
            'index'        => ['GET', 'api.tasks.index'],
            'store'        => ['POST', 'api.tasks.store'],
            'show'         => ['GET', 'api.tasks.show'],
            'update'       => ['PUT', 'api.tasks.update'],
            'toggleStatus' => ['PATCH', 'api.tasks.toggle-status'],
            'destroy'      => ['DELETE', 'api.tasks.destroy'],
        ];
    }
}
