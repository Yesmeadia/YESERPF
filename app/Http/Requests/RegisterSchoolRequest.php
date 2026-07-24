<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Sanitize input before validation — force uppercase on text fields.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'           => $this->name           ? strtoupper(trim($this->name))           : $this->name,
            'principal_name' => $this->principal_name ? strtoupper(trim($this->principal_name)) : $this->principal_name,
            'address'        => $this->address        ? strtoupper(trim($this->address))        : $this->address,
            'suic_code'      => $this->suic_code      ? strtoupper(trim($this->suic_code))      : $this->suic_code,
            'phone'          => $this->phone          ? trim($this->phone)                      : $this->phone,
            'email'          => $this->email          ? strtolower(trim($this->email))          : $this->email,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'                      => ['required', 'string', 'min:3', 'max:255'],
            'state_id'                  => ['required', 'exists:states,id'],
            'zone_id'                   => ['required', 'exists:zones,id'],
            'category_id'               => ['required', 'exists:categories,id'],
            'principal_name'            => ['required', 'string', 'min:3', 'max:255'],
            'email'                     => ['required', 'email:rfc', 'max:255'],
            'phone'                     => ['required', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'address'                   => ['required', 'string', 'min:10', 'max:1000'],
            // SUIC: exactly 6 uppercase alphabetical letters & unique across all schools
            'suic_code'                 => ['required', 'string', 'size:6', 'regex:/^[A-Z]{6}$/', 'unique:schools,suic_code'],
            // Students (gender-wise)
            'male_students'             => ['required', 'integer', 'min:0', 'max:999999'],
            'female_students'           => ['required', 'integer', 'min:0', 'max:999999'],
            // Teaching staff (gender-wise)
            'teaching_male_staff'       => ['required', 'integer', 'min:0', 'max:99999'],
            'teaching_female_staff'     => ['required', 'integer', 'min:0', 'max:99999'],
            // Non-teaching staff (gender-wise)
            'non_teaching_male_staff'   => ['required', 'integer', 'min:0', 'max:99999'],
            'non_teaching_female_staff' => ['required', 'integer', 'min:0', 'max:99999'],
        ];
    }

    public function messages(): array
    {
        return [
            // Dropdowns
            'state_id.required'    => 'Please select a state.',
            'zone_id.required'     => 'Please select a zone for the selected state.',
            'category_id.required' => 'Please select an institution category.',

            // School name
            'name.required' => 'School name is required.',
            'name.min'      => 'School name must be at least 3 characters.',
            'name.max'      => 'School name must not exceed 255 characters.',

            // SUIC
            'suic_code.required' => 'SUIC code is required.',
            'suic_code.size'     => 'SUIC code must be exactly 6 uppercase letters.',
            'suic_code.regex'    => 'SUIC code must contain exactly 6 uppercase letters (A–Z), no numbers or symbols.',
            'suic_code.unique'   => 'This SUIC code is already taken by another registered school. Please enter a unique 6-letter SUIC code.',

            // Phone
            'phone.required' => 'Contact number is required.',
            'phone.regex'    => 'Enter a valid phone number (digits, +, -, spaces allowed).',

            // Email
            'email.required' => 'Email address is required.',
            'email.email'    => 'Enter a valid email address.',

            // Address
            'address.required' => 'School address is required.',
            'address.min'      => 'Address must be at least 10 characters.',

            // Principal
            'principal_name.required' => 'Principal name is required.',
            'principal_name.min'      => 'Principal name must be at least 3 characters.',

            // Students
            'male_students.required'   => 'Number of male students is required.',
            'male_students.min'        => 'Value cannot be negative.',
            'female_students.required' => 'Number of female students is required.',
            'female_students.min'      => 'Value cannot be negative.',

            // Staff
            'teaching_male_staff.required'       => 'Male teaching staff count is required.',
            'teaching_male_staff.min'            => 'Value cannot be negative.',
            'teaching_female_staff.required'     => 'Female teaching staff count is required.',
            'teaching_female_staff.min'          => 'Value cannot be negative.',
            'non_teaching_male_staff.required'   => 'Male non-teaching staff count is required.',
            'non_teaching_male_staff.min'        => 'Value cannot be negative.',
            'non_teaching_female_staff.required' => 'Female non-teaching staff count is required.',
            'non_teaching_female_staff.min'      => 'Value cannot be negative.',
        ];
    }
}
