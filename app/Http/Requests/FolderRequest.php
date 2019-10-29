<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FolderRequest extends FormRequest
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
            'name'=>'required|min:3|max:150|unique:folders,name,'.$this->getId(),
            'description' => 'nullable|min:3|max:250',
        ];
    }

    public function getId()
    {
        if (isset($this->folder->id)) {
            return $this->folder->id;
        } else {
            return null;
        }
    }

    public function messages()
    {
        return[
            'name.unique' => 'This folder name is taken before',
        ];
    }
}
