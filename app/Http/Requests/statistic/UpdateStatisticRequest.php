<?php

namespace App\Http\Requests\statistic;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatisticRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('workout')->program->published && $this->route('statistic')->user_id == auth()->id();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reps' => ['nullable', 'numeric', 'min:0'],
            'time' => ['nullable', 'numeric', 'min:0'],
            'set_number' => ['nullable', 'numeric', 'min:0'],
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
