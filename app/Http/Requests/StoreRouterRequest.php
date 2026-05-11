<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRouterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:tbl_routers'],
            'ip_address' => ['required', 'ip', 'unique:tbl_routers'],
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
            'ip_address.unique' => 'IP address sudah terdaftar',
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'port.required' => 'Port wajib diisi',
            'port.between' => 'Port harus antara 1-65535',
        ];
    }
}
