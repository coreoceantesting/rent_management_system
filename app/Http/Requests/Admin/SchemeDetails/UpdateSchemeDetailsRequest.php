<?php

namespace App\Http\Requests\Admin\SchemeDetails;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchemeDetailsRequest extends FormRequest
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
            'scheme_id' => 'nullable',
            'region_name' => 'required',
            'ward_name' => 'required',
            'village_name' => 'required',
            'scheme_name' => 'required',
            'scheme_address' => 'required',
            'scheme_cst_number' => 'required',
            'scheme_proposal_number' => 'required',
            'developer_name' => 'required',
            'developer_email' => 'required|email',
            'developer_contact_number' => 'required|digits:10',
            'architect_name' => 'required',
            'architect_email' => 'required|email',
            'architect_contact_number' => 'required|digits:10',
        ];
    }
}
