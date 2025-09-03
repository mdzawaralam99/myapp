<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' =>'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'nullable|string',
            'status' => 'nullable|boolean'
        ];
    }

   /**
    * custom error message
    */

   public function messages():array{
    return [
        'name.required' => 'Please provide your name',
        'name.string' => 'Name must be a valid string',
        'email.required' => 'We need your email address',
        'email.email' => 'The email format is invalid',
        'email.unique' => 'This email is already registered',
        'password.required' => 'Please provide a password',
        'password.min' => 'Password must be at least 6 characters long'
    ];
   }
}
