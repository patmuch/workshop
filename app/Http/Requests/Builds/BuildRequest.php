<?php

namespace App\Http\Requests\Builds;

use Illuminate\Foundation\Http\FormRequest;

class BuildRequest extends FormRequest
{
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'buildable_id'    => 'required',
            'buildable_type'   => 'required',
            'user_id'     => 'required ',
            'notes'       => 'required',
            'production_stage_id' => 'required',

        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'buildable_id'  => 'required',
            'buildable_type' => 'required',
            'user_id'     => 'required ',
            'notes'       => 'required',
            'production_stage_id' => 'required',
        ];
    }
}