<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Laravel\Prompts\password;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email"=> "required|email",
            "password"=> "required|min:6",
        ];
    }

    public function messages(): array
    {
        return [
            "email.required"=> "Please enter an email",
            "email.email" =>"Please enter a valid email address",
            "password.required" => "Please enter a password",
            "password.min:6" => "Password length must be atleast 6 characters",
        ];
    }
}
