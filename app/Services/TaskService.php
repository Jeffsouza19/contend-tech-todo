<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class TaskService
{
    /**
     * Get all tasks for a specific user.
     */
    public function getAllForUser(User $user, int $perPage = 10): Paginator
    {
        return Task::query()->where('user_id', $user->id)
            ->latest()
            ->simplePaginate($perPage);
    }

    /**
     * Get a specific task by ID, ensuring it belongs to the user.
     */
    public function getByIdForUser(int $taskId, User $user): ?Task
    {
        return Task::query()->where('id', $taskId)
            ->where('user_id', $user->id)
            ->first();
    }

    /**
     * Create a new task for a user.
     */
    public function create(array $data, User $user): Task
    {
        $data['user_id'] = $user->id;

        return Task::query()->create($data);
    }

    /**
     * Update an existing task.
     */
    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    /**
     * Toggles the status of a task between 'pendente' and 'concluída'.
     */
    public function toggleStatus(Task $task): Task
    {
        $newStatus = $task->status === 'concluída' ? 'pendente' : 'concluída';

        $this->update($task, ['status' => $newStatus]);

        return $task->refresh();
    }

    /**
     * Delete a task.
     */
    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    /**
     * Check if a task belongs to a specific user.
     */
    public function belongsToUser(Task $task, User $user): bool
    {
        return $task->user_id === $user->id;
    }
}
