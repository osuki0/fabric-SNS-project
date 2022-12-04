<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostImageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image.*' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'dimensions:min_width=50,min_height=50,max_width=3000,max_height=3000'
                ],
            'image' => ['required', 'array', 'min:1', 'max:3'], 
        ];
    }
    
}
