<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivateVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:55',
            'customer_username' => 'required|string|max:45',
        ];
    }
}
