<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostEditRequest extends FormRequest
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
            'description' => ['required', 'max:1000'],
            'price' => ['nullable', 'integer', 'min:300', 'max:1000000'],
            'delivery_charge' => ['nullable',],
            'method_of_shipment' => ['nullable'],
            'days_to_derivery' => ['nullable'],
        ];
    }
    
}
