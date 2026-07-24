<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSchoolStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->canReview();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'state_id' => ['required', 'exists:states,id'],
            'zone_id' => ['required', 'exists:zones,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'principal_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'suic_code' => ['required', 'string', 'max:50'],
            'total_students' => ['required', 'integer', 'min:0'],
            'total_teachers' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:registered,under_construction,trial_running,on_going'],
        ];
    }
}
