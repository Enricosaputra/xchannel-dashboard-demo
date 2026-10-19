<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:2000'],
            'hosts' => ['array'],
            'hosts.*' => ['exists:hosts,id'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
