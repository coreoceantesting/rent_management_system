<?php

namespace App\Http\Requests\Admin\TenantsDetails;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantsDetailsRequest extends FormRequest
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
            'name_of_tenant' => 'required',
            'annexure_no' => 'required',
            'scheme_name' => 'required',
            'eligible_or_not' => 'required',
            'residential_or_commercial' => 'required',
            'mobile_no' => 'required|digits:10',
            'aadhaar_no' => 'required|digits:12',
        ];
    }
}
