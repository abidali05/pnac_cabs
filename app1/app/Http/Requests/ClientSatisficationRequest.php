<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSatisficationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'accredited' => 'required|string|in:Yes,No',

            'government_req' => 'required|array',
            'government_req.*' => 'string',

            'customer_demand' => 'required|array',
            'customer_demand.*' => 'string',

            'purpose' => 'required|string',
            'business_purpose' => 'required|string',
            'accredited_general' => 'required|string',
            'other_reason' => 'required|string',

            'reports' => 'required|string',
            'excepted' => 'required|string|in:Yes,No',
            'outcome' => 'required|string|in:Yes,No',
            'system_improved' => 'required|string|in:Yes,No',
            'clientage' => 'required|string',
            'government_regarding' => 'required|string',
            'suggestion' => 'required|string',
        ];
    }
}
