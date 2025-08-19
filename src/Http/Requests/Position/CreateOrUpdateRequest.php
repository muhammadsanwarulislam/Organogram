<?php
declare(strict_types=1);
namespace Sanwarul\Organogram\Controllers\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|unique:positions,code',
            'grade'         => 'nullable|integer',
            'responsibilities'   => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'The department field is required.',
            'name.required'          => 'The position name is required.',
            'code.required'          => 'The position code is required.',
            'code.unique'            => 'The position code must be unique.',
            'grade.integer'          => 'The grade must be an integer.',
            'responsibilities.string' => 'Responsibilities must be a string if provided.',
        ];
    }
}