<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
            'image' => 'required_without_all:file,video_pc|image|mimes:png,jpg|max:2048',
            'file' => 'required_without_all:image,vidro_pc|file|max:2048|mimes:pdf,xlsx',
            'video_pc'=>'required_without_all:image,file|file|mimes:mpeg,ogg,mp4',
            'name'=>'required_with:image,file,video_pc|nullable|min:3|max:150',
            'description' => 'nullable|min:3|max:250',
        ];
    }

    public function messages()
    {
        return[
            'required_without_all' => 'The field :attribute is required.',
        ];
    
    }

}
