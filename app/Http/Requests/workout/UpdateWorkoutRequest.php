<?php

namespace App\Http\Requests\workout;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkoutRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('program')->created_by == auth()->id()
            && $this->route('workout')->program->created_by == auth()->id();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'set_number' => $this->set_number != null
                ? $this->set_number
                : $this->workout->set_number,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $prevable_type = $this->request->get('prevable_type');
        $prev_id_rules = Rule::exists($prevable_type . 's', 'id');
        return [
            'prevable_id' => ['nullable', 'numeric', 'required_with:prevable_type', $prevable_type ? $prev_id_rules : ''],
            'prevable_type' => ['nullable', 'string', 'max:255'],
            'set_id' => ['nullable', 'numeric', 'exists:sets,id'],
            'day' => ['nullable', 'numeric', 'min:0'],
            'reps_based' => ['nullable', 'boolean'],
            'reps' => ['nullable', 'numeric', 'min:0'],
            'time_based' => ['nullable', 'boolean'],
            'time' => ['nullable', 'numeric', 'min:0'],
            'set_number' => ['bail', 'required', 'numeric', 'min:0'],
            'rest_time' => ['nullable', 'numeric', 'min:0'],
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
