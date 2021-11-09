<?php

namespace App\Http\Requests\Materials;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'material_name' => 'required|string|max:191',
            'material_code' => 'required|string|max:30|unique:materials',
            'description' => 'required|string|max:1000',
            'reorder_level' => 'required|numeric',
            'costprice' => 'required|numeric',
            'quantity' => 'required|numeric',
            'material_category_id' => 'required|integer|exists:material_categories,id',
            'uom_id' => 'required|integer|exists:uoms,id',
            // 'photo' => 'sometimes|files',
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
            'material_name' => 'required|string|max:191',
            'material_code' => 'required|string|max:30',
            'description'   => 'required|string|max:1000',
            'reorder_level' => 'required|numeric',
            'costprice'     => 'required|numeric',
            'quantity'      => 'required|numeric',
            'material_category_id' => 'required|integer|exists:material_categories,id',
            'uom_id' => 'required|integer|exists:uoms,id',
            // 'photo' => 'sometimes|files',
        ];
    }
}
