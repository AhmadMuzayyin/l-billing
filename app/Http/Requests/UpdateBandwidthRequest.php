<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBandwidthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100', Rule::unique('tbl_bandwidth')->ignore($this->bandwidth)],
            'upload_limit' => ['required', 'integer', 'min:1'],
            'download_limit' => ['required', 'integer', 'min:1'],
            'burst_upload' => ['nullable', 'integer', 'min:1'],
            'burst_download' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama bandwidth wajib diisi',
            'upload_limit.required' => 'Upload limit wajib diisi',
            'download_limit.required' => 'Download limit wajib diisi',
        ];
    }
}
