<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:registered,under_construction,trial_running,on_going'],
            'notes'  => ['nullable', 'string', 'max:1000'],
        ];
    }
}
