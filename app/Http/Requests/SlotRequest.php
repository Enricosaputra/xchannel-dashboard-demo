<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SlotRequest extends FormRequest
{
    public function rules(): array
    {
        // HH:MM, 00:00 to 24:00. Free-text times like "6:00 AM - 10:00 AM" are what production struggles with.
        $time = ['required', 'regex:/^(([01]\d|2[0-3]):[0-5]\d|24:00)$/D'];
        $creating = $this->isMethod('post');

        return [
            'station_id' => ['required', 'exists:stations,id'],
            'show_id' => ['required', 'exists:shows,id'],
            'days' => [Rule::requiredIf($creating), 'array'],
            'days.*' => ['integer', 'between:1,7'],
            'day_of_week' => [Rule::requiredIf(! $creating), 'integer', 'between:1,7'],
            'starts_at' => $time,
            'ends_at' => $time,
        ];
    }
}
