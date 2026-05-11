<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:tbl_customers|min:3|max:50',
            'password' => 'required|string|min:6|confirmed',
            'fullname' => 'required|string|max:45',
            'email' => 'required|email|max:100',
            'phonenumber' => 'nullable|string|max:20',
            'status' => 'required|in:Active,Banned,Disabled,Inactive,Limited,Suspended',
            'auto_renewal' => 'boolean',
            'balance' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => 'Username sudah digunakan',
            'password.confirmed' => 'Password tidak cocok',
            'email.email' => 'Email tidak valid',
        ];
    }
}
