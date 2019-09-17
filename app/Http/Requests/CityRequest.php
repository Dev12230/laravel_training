<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
        $countryId=$this->input('country_id');
        return [
            'city_name'=>'required|max:150|unique:cities,city_name,NULL,id,country_id,'.$countryId,
            'country_id' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'city_name.required' => 'City name is required',
            'city_name.max' => 'Maximum character is 150',
            'City_name.unique' => 'This city name and this country is taken before',
            'country_id.required' => 'Country is required',
        ];
    }
}
