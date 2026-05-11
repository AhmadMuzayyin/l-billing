<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendBulkMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:100'],
            'message' => ['required', 'string', 'min:5', 'max:5000'],
            'customer_ids' => ['required', 'array', 'min:1'],
            'customer_ids.*' => ['required', 'integer', 'exists:tbl_customers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul pesan wajib diisi',
            'message.required' => 'Isi pesan wajib diisi',
            'customer_ids.required' => 'Pilih minimal 1 pelanggan',
        ];
    }
}
