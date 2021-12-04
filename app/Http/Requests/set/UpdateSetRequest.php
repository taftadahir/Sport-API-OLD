<?php

namespace App\Http\Requests\set;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSetRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return
            $this->route('program')->created_by == auth()->id()
            && $this->route('set')->program->created_by == auth()->id();
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
                : $this->set->name,
            'number' => $this->number != null
                ? $this->number
                : $this->set->number
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
            'name' => ['bail', 'required', 'string', 'max:255'],
            'day' => ['nullable', 'numeric', 'min:0'],
            'number' => ['bail', 'required', 'numeric', 'min:0'],
            'rest_time' => ['nullable', 'numeric', 'min:0'],
            'warm_up_set' => ['nullable', 'boolean'],
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
