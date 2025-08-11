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
        $task        = Task::query()->find($this->route('task')->id);
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

    #[\Override]
    public function messages(): array
    {
        return [
            'title.required'       => 'O campo título é obrigatório.',
            'description.required' => 'O campo descrição é obrigatório',
            'status.required'      => 'O campo status é obrigatório',
        ];
    }
}
