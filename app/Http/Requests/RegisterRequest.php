<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:50|',
            'last_name' => 'required|string|min:2|max:50|',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:5|max:255|confirmed',
            'terms_and_conditions' => 'required'
        ];
    }
}
