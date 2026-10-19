<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
