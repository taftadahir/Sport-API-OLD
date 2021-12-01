<?php

namespace App\Http\Requests\exercise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExerciseRequest extends FormRequest
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
            'name' => [
                'bail', 'required', 'string', 'max:255',
                Rule::unique('exercises')->where('created_by', $this->user()->id)
            ],
            'time_based' => ['nullable', 'boolean'],
            'reps_based' => ['nullable', 'boolean'],
            'published' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'string', 'max:255']
        ];
    }
}
