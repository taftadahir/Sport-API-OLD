<?php

namespace App\Http\Requests\set;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSetRequest extends FormRequest
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
        // 
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
            'prevable_type' => ['nullable', 'string', 'max:255'],
            'prevable_id' => ['nullable', 'numeric', 'required_with:prevable_type', $prevable_type ? $prev_id_rules : ''],
            'name' => ['bail', 'required', 'string', 'max:255'],
            'day' => ['nullable', 'numeric', 'min:0'],
            'set' => ['bail', 'required', 'numeric', 'min:0'],
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
