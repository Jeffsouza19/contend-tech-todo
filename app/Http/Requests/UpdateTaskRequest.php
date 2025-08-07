<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Services\TaskService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task        = $this->route('task');
        $taskService = app(TaskService::class);

        return $taskService->belongsToUser($task, $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|in:pendente,concluída',
        ];
    }
}
