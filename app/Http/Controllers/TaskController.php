<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(
        /**
         * The task service instance.
         */
        protected TaskService $taskService
    ) {
    }

    public function index(Request $request): View
    {
        $tasks = $this->taskService->getAllForUser($request->user());

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $this->taskService->create($request->validated(), $request->user());

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task): View
    {
        return view('tasks.show', ['task' => $task]);
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', ['task' => $task]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->taskService->update($task, $request->validated());

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    public function toggleStatus(Task $task): RedirectResponse
    {
        $this->taskService->toggleStatus($task);

        $message = $task->status === 'concluída'
            ? "A tarefa '{$task->title}' foi marcada como concluída."
            : "A tarefa '{$task->title}' foi marcada como pendente.";

        return redirect()->route('tasks.index')->with('success', $message);
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->taskService->delete($task);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa deletada com sucesso.');
    }
}
