<?php

namespace App\Http\Requests;

use App\Enums\Priority;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StorePatientRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            'patientName' => ['required', 'min:8', 'string'],
            'urgency' => ['required', 'string', Rule::enum(Priority::class)],
            'reason' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }
    /**
     * Custom message for the invalid request
     * @return array{"patientName.required": string}
     */
    public function messages(): array
    {
        return [
            'patientName.required'=>'Patient name is required.'
        ];
    }
}
