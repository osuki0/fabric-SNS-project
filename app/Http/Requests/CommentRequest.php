<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
 
    public function rules()
    {
        return [
            'post_id' => ['required'],
            'body' => ['required', 'max:200'],
        ];
    }
    
}
