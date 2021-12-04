<?php

namespace App\Http\Requests\exercise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExerciseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('exercise')->created_by == auth()->id();
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
                : $this->exercise->name
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
            'name' => ['nullable', 'string', 'max:255', Rule::unique('exercises')->where('created_by', $this->user()->id)->ignore($this->exercise->id)],
            'time_based' => ['nullable', 'boolean'],
            'reps_based' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'image' => ['nullable', 'string', 'max:255']
        ];
    }
}
