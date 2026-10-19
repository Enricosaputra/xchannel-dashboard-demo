<?php

// Only the rules this app uses.
return [
    'between' => [
        'numeric' => ':Attribute harus di antara :min dan :max.',
    ],
    'distinct' => ':Attribute tidak boleh sama.',
    'array' => ':Attribute harus berupa daftar.',
    'boolean' => ':Attribute harus bernilai benar atau salah.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'enum' => ':Attribute yang dipilih tidak valid.',
    'exists' => ':Attribute yang dipilih tidak valid.',
    'integer' => ':Attribute harus berupa bilangan bulat.',
    'max' => [
        'string' => ':Attribute maksimal :max karakter.',
    ],
    'not_in' => ':Attribute yang dipilih tidak valid.',
    'numeric' => ':Attribute harus berupa angka.',
    'required' => ':Attribute wajib diisi.',
    'string' => ':Attribute harus berupa teks.',
    'unique' => ':Attribute sudah dipakai.',

    'after_or_equal' => ':Attribute harus sama dengan atau setelah :date.',
    'in' => ':Attribute yang dipilih tidak valid.',
    'min' => [
        'numeric' => ':Attribute minimal :min.',
        'array' => ':Attribute minimal :min pilihan.',
    ],
    'prohibited_unless' => ':Attribute hanya boleh diisi jika :other bernilai :values.',
    'regex' => 'Format :attribute tidak valid.',
    'required_with' => ':Attribute wajib diisi jika :values diisi.',

    'url' => 'Format :attribute tidak valid.',
    'required_if' => ':Attribute wajib diisi.',

    'attributes' => [
        'name' => 'nama',
        'city' => 'kota',
        'frequency' => 'frekuensi',
        'stream_url' => 'URL streaming',
        'stream_status' => 'status streaming',
        'bio' => 'bio',
        'title' => 'judul',
        'description' => 'deskripsi',
        'hosts' => 'penyiar',
        'station_id' => 'stasiun',
        'show_id' => 'program',
        'days' => 'hari',
        'day_of_week' => 'hari',
        'starts_at' => 'jam mulai',
        'ends_at' => 'jam selesai',
    ],
];
