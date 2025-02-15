<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:pending,done',
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => 'El campo título es obligatorio.',
            'title.string'         => 'El título debe ser una cadena de texto.',
            'description.string'   => 'La descripción debe ser una cadena de texto.',
            'status.in'            => 'El estado debe ser "pending" o "done".',
        ];
    }
}
