<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $tasks = $this->taskService->getAllForUser($request->user());

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request->validated(), $request->user());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource | JsonResponse
    {
        if ($this->taskService->belongsToUser($task, request()->user())) {
            return new TaskResource($task);
        }

        return response()->json(['message' => 'Tarefa Indisponivel'], Response::HTTP_FORBIDDEN);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $updatedTask = $this->taskService->update($task, $request->validated());

        return new TaskResource($updatedTask);
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Request $request, Task $task): TaskResource | JsonResponse
    {
        if ($this->taskService->belongsToUser($task, request()->user())) {
            $updatedTask = $this->taskService->toggleStatus($task);

            return new TaskResource($updatedTask);
        }

        return response()->json(['message' => 'Tarefa Indisponivel'], Response::HTTP_FORBIDDEN);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): Response | JsonResponse
    {
        if ($this->taskService->belongsToUser($task, request()->user())) {
            $this->taskService->delete($task);

            return response()->noContent();
        }

        return response()->json(['message' => 'Tarefa Indisponivel'], Response::HTTP_FORBIDDEN);
    }
}
