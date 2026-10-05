<?php

return [

    /*
    |--------------------------------------------------------------------------
    | BPJS VClaim API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for BPJS (Badan Penyelenggara Jaminan Sosial) VClaim API
    | integration. This enables verification of patient eligibility and
    | claim submission to Indonesian national health insurance system.
    |
    */

    'base_url' => env('BPJS_BASE_URL', 'https://apijkndev.bpjs-kesehatan.go.id'),

    'cons_id' => env('BPJS_CONS_ID', ''),

    'secret_key' => env('BPJS_SECRET_KEY', ''),

    'user_key' => env('BPJS_USER_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    |
    | Timeout and retry configuration for BPJS API requests.
    |
    */

    'timeout' => env('BPJS_TIMEOUT', 10), // seconds

    'retry_times' => env('BPJS_RETRY_TIMES', 3),

    'retry_delay' => env('BPJS_RETRY_DELAY', 1000), // milliseconds

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Set to 'production' for live BPJS API or 'development' for testing.
    | Production URL: https://apijkn.bpjs-kesehatan.go.id
    | Development URL: https://apijkndev.bpjs-kesehatan.go.id
    |
    */

    'environment' => env('BPJS_ENV', 'development'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | VClaim API endpoint paths
    |
    */

    'endpoints' => [
        'peserta' => '/Peserta',
        'sep' => '/SEP',
        'rujukan' => '/Rujukan',
        'rencana_kontrol' => '/RencanaKontrol',
        'monitoring' => '/Monitoring',
        'reference' => '/referensi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache duration for BPJS reference data (diagnoses, procedures, etc.)
    |
    */

    'cache_duration' => env('BPJS_CACHE_DURATION', 86400), // 24 hours in seconds

    /*
    |--------------------------------------------------------------------------
    | Hospital Identifiers
    |--------------------------------------------------------------------------
    |
    | Hospital-specific codes for BPJS integration
    |
    */

    'pcare_username' => env('BPJS_PCARE_USERNAME', ''),
    
    'pcare_password' => env('BPJS_PCARE_PASSWORD', ''),

    'ppk_code' => env('BPJS_PPK_CODE', ''), // Kode PPK Rumah Sakit

];
