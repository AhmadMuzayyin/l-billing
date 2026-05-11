<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul pesan wajib diisi',
            'message.required' => 'Isi pesan wajib diisi',
            'message.min' => 'Isi pesan minimal 5 karakter',
        ];
    }
}
