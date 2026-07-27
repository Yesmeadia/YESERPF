<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSchoolUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'           => $this->name           ? strtoupper(trim($this->name))           : $this->name,
            'principal_name' => $this->principal_name ? strtoupper(trim($this->principal_name)) : $this->principal_name,
            'address'        => $this->address        ? strtoupper(trim($this->address))        : $this->address,
            'suic_code'      => $this->suic_code      ? strtoupper(trim($this->suic_code))      : $this->suic_code,
            'email'          => $this->email          ? strtolower(trim($this->email))          : $this->email,
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'                      => ['required', 'string', 'min:3', 'max:255'],
            'state_id'                  => ['required', 'exists:states,id'],
            'zone_id'                   => ['required', 'exists:zones,id'],
            'category_id'               => ['required', 'exists:categories,id'],
            'principal_name'            => ['required', 'string', 'min:3', 'max:255'],
            'email'                     => ['required', 'email:rfc', 'max:255'],
            'phone'                     => ['required', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'address'                   => ['required', 'string', 'min:10', 'max:1000'],
            'suic_code'                 => ['required', 'string', 'size:6', 'regex:/^[A-Z]{6}$/', "unique:schools,suic_code,{$id}"],
            // Gender-disaggregated staff
            'teaching_male_staff'       => ['required', 'integer', 'min:0', 'max:99999'],
            'teaching_female_staff'     => ['required', 'integer', 'min:0', 'max:99999'],
            'non_teaching_male_staff'   => ['required', 'integer', 'min:0', 'max:99999'],
            'non_teaching_female_staff' => ['required', 'integer', 'min:0', 'max:99999'],
            // Students
            'male_students'             => ['required', 'integer', 'min:0', 'max:999999'],
            'female_students'           => ['required', 'integer', 'min:0', 'max:999999'],
            // Domain
            'existing_domain'           => ['nullable', 'string', 'max:255'],
            'desired_domain'            => ['nullable', 'string', 'max:255'],
            // Status
            'status'                    => ['required', 'in:registered,under_construction,trial_running,on_going'],
        ];
    }

    public function messages(): array
    {
        return [
            'suic_code.unique' => 'This SUIC code is already taken by another school.',
            'suic_code.size'   => 'SUIC code must be exactly 6 uppercase letters.',
            'suic_code.regex'  => 'SUIC code must contain only uppercase letters A–Z.',
        ];
    }
}
