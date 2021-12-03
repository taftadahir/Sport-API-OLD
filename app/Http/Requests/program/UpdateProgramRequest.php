<?php

namespace App\Http\Requests\program;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('program')->created_by == auth()->id();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->name != null
                ? $this->name
                : $this->program->name
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('programs')->where('created_by', $this->user()->id)->ignore($this->program->id)],
            'days' => ['nullable', 'integer', 'min:0'],
            'use_warm_up' => ['nullable', 'boolean'],
            'use_program_set' => ['nullable', 'boolean'],
            'use_workout_set' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'image' => ['nullable', 'string', 'max:255']
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        //
    }
}
