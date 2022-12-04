<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profile' => ['nullable', 'max:1000'],
            'first_name' => ['nullable', 'min:1', 'max:50'],
            'last_name' => ['nullable', 'min:1', 'max:50'],
            'phone' => ['nullable', 'regex:/\A[0-9]{2,4}-?[0-9]{2,4}-?[0-9]{3,4}\z/'],
            'postal_code' => ['nullable', 'regex:/\A[0-9]{3}-[0-9]{4}/'],
            'address' => ['nullable', 'max:1000'],
        ];
    }
    
}
