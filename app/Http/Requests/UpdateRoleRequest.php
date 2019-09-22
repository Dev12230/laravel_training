<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        return [
            'name'=>'required|max:150|unique:roles,name,'.$this->role['id'],
            'description' => 'required|max:250',
        ];
    }


    public function messages()
    {
        return[
            'name.required' => 'Role name is required',
            'name.max' => 'Maximum character is 150',
            'name.unique' => 'This role name is taken before',
            'description.required' => 'Description is required',
            'description.max' => 'Maximum character is 250'
        ];
    }
}
