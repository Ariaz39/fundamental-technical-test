<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'       => 'sometimes|string',
            'description' => 'sometimes|nullable|string',
            'status'      => 'sometimes|in:pending,done',
        ];
    }

    public function messages()
    {
        return [
            'title.string'         => 'El título debe ser una cadena de texto.',
            'description.string'   => 'La descripción debe ser una cadena de texto.',
            'status.in'            => 'El estado debe ser "pending" o "done".',
        ];
    }
}
