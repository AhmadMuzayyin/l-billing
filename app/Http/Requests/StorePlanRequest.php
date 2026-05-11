<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_plan' => 'required|string|max:40',
            'id_bw' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:Hotspot,PPPOE,Balance,VPN',
            'validity' => 'required|integer|min:1',
            'validity_unit' => 'required|in:Mins,Hrs,Days,Months,Period',
            'routers' => 'nullable|string|max:32',
            'enabled' => 'boolean',
            'is_radius' => 'boolean',
            'prepaid' => 'required|in:yes,no',
            'plan_type' => 'required|in:Business,Personal',
        ];
    }
}
