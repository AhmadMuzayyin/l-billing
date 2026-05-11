<?php

namespace App\Http\Requests;

use App\Models\Legacy\Customer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customer = $this->route('customer');
        $customerId = $customer instanceof Customer ? $customer->id : $customer;

        return [
            'username' => "required|string|unique:tbl_customers,username,{$customerId}|min:3|max:50",
            'password' => 'nullable|string|min:6|confirmed',
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
