<?php

namespace App\Http\Requests\program;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProgramRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('programs')->where('created_by', $this->user()->id)],
            'days' => ['nullable', 'integer', 'min:0'],
            'use_warm_up' => ['nullable', 'boolean'],
            'use_program_set' => ['nullable', 'boolean'],
            'use_workout_set' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'image' => ['nullable', 'string', 'max:255']
        ];
    }
}
