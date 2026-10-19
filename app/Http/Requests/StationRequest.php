<?php

namespace App\Http\Requests;

use App\Enums\StreamStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'frequency' => ['required', 'string', 'max:20', 'regex:/^\d{2,3}([.,]\d)? FM$/D'],
            'stream_url' => ['nullable', 'url:http,https', 'max:255'],
            'stream_status' => ['required', Rule::enum(StreamStatus::class)],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active'), 'frequency' => strtoupper(trim((string) $this->input('frequency')))]);
    }
}
