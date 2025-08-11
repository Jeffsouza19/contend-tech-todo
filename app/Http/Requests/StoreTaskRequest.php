<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'description' => 'required|string',
            'status'      => 'required|in:pendente,concluída',
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
