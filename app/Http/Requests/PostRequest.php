<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:20'],
            'genre_id' => ['required', 'exists:genres,id'],
            'image.*' => [
                'required', 'file', 'image',
                'mimes:jpg,jpeg,png',
                'dimensions:min_width=50,min_height=50,max_width=5000,max_height=5000'
                ],
            'image' => ['required', 'array', 'min:1', 'max:3'], 
            'description' => ['required', 'max:1000'],
            'price' => ['nullable', 'integer', 'min:300', 'max:1000000'],
            'delivery_charge' => ['nullable',],
            'method_of_shipment' => ['nullable'],
            'days_to_derivery' => ['nullable'],
        ];
    }
    
}
