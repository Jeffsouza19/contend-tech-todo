<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task        = Task::query()->first($this->route('task'));
        $taskService = app(TaskService::class);

        if (! $task) {
            return false;
        }

        return $taskService->belongsToUser($task, $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string|sometimes',
            'status'      => 'required|in:pendente,concluída|sometimes',
        ];
    }
}
