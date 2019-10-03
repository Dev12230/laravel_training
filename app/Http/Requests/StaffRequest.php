<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'image' => 'image|mimes:png,jpg|max:2048',
            'first_name'=>'required|max:150',
            'last_name'=>'required|max:150',
            'email' => 'required|string|email|unique:users,email,'.$this->getId().',id,deleted_at,NULL',
            'phone'=>'required|regex:/(01)[0-9]{9}/||unique:users,phone,'.$this->getId().',id,deleted_at,NULL',
            'job_id'=>'required',
            'city_id'=>'required',
            'country_id'=>'required',

        ];
    }

    public function getId()
    {
        if (isset($this->staff->user->id)) {
            return $this->staff->user->id;
        } else {
            return null;
        }
    }

    public function messages()
    {
        return[
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'role_id.required' => 'Role is required',
            'job_id.required' => 'Job is required',
            'city_id.required' => 'City is required',
            'country_id.required' => 'Country is required',
            'first_name.max' => 'Maximum character is 150',
            'last_name.max' => 'Maximum character is 150',
            'email.unique' => 'This email is taken before',
            'phone.regex' => 'phone is not valid ex: 01(123456789)'

        ];
    }
}
