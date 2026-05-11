<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRouterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100', Rule::unique('tbl_routers')->ignore($this->router)],
            'ip_address' => ['required', 'ip', Rule::unique('tbl_routers')->ignore($this->router)],
            'username' => ['required', 'string', 'min:3', 'max:50'],
            'password' => ['required', 'string', 'min:6', 'max:100'],
            'port' => ['required', 'integer', 'between:1,65535'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama router wajib diisi',
            'ip_address.required' => 'IP address wajib diisi',
            'ip_address.ip' => 'IP address tidak valid',
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'port.required' => 'Port wajib diisi',
        ];
    }
}
