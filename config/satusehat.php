<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SATUSEHAT Platform Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for SATUSEHAT (Ministry of Health Indonesia) integration.
    | SATUSEHAT uses HL7 FHIR R4 standard for health data exchange.
    |
    */

    'base_url' => env('SATUSEHAT_BASE_URL', 'https://api-satusehat-dev.dto.kemkes.go.id'),

    'auth_url' => env('SATUSEHAT_AUTH_URL', 'https://api-satusehat-dev.dto.kemkes.go.id/oauth2/v1/accesstoken'),

    /*
    |--------------------------------------------------------------------------
    | OAuth2 Credentials
    |--------------------------------------------------------------------------
    |
    | OAuth2 client credentials provided by Ministry of Health
    |
    */

    'client_id' => env('SATUSEHAT_CLIENT_ID', ''),

    'client_secret' => env('SATUSEHAT_CLIENT_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Organization Identifier
    |--------------------------------------------------------------------------
    |
    | Hospital's organization ID in SATUSEHAT platform
    |
    */

    'organization_id' => env('SATUSEHAT_ORGANIZATION_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    |
    | Timeout and retry configuration for SATUSEHAT API requests.
    |
    */

    'timeout' => env('SATUSEHAT_TIMEOUT', 15), // seconds

    'retry_times' => env('SATUSEHAT_RETRY_TIMES', 3),

    'retry_delay' => env('SATUSEHAT_RETRY_DELAY', 2000), // milliseconds

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Set to 'production' for live SATUSEHAT API or 'development' for testing.
    | Production URL: https://api-satusehat.kemkes.go.id
    | Development URL: https://api-satusehat-dev.dto.kemkes.go.id
    |
    */

    'environment' => env('SATUSEHAT_ENV', 'development'),

    /*
    |--------------------------------------------------------------------------
    | FHIR Resource Endpoints
    |--------------------------------------------------------------------------
    |
    | FHIR R4 resource endpoint paths
    |
    */

    'endpoints' => [
        'patient' => '/fhir-r4/v1/Patient',
        'practitioner' => '/fhir-r4/v1/Practitioner',
        'organization' => '/fhir-r4/v1/Organization',
        'location' => '/fhir-r4/v1/Location',
        'encounter' => '/fhir-r4/v1/Encounter',
        'observation' => '/fhir-r4/v1/Observation',
        'condition' => '/fhir-r4/v1/Condition',
        'procedure' => '/fhir-r4/v1/Procedure',
        'medication' => '/fhir-r4/v1/Medication',
        'medication_request' => '/fhir-r4/v1/MedicationRequest',
        'allergy_intolerance' => '/fhir-r4/v1/AllergyIntolerance',
        'immunization' => '/fhir-r4/v1/Immunization',
        'composition' => '/fhir-r4/v1/Composition',
    ],

    /*
    |--------------------------------------------------------------------------
    | Submission Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for automated data submission to SATUSEHAT
    |
    */

    'auto_submit' => env('SATUSEHAT_AUTO_SUBMIT', false),

    'submission_queue' => env('SATUSEHAT_SUBMISSION_QUEUE', 'high'),

    'batch_size' => env('SATUSEHAT_BATCH_SIZE', 50),

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache duration for OAuth2 tokens and reference data
    |
    */

    'token_cache_duration' => env('SATUSEHAT_TOKEN_CACHE', 3600), // 1 hour

    'cache_prefix' => env('SATUSEHAT_CACHE_PREFIX', 'satusehat'),

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Enable detailed logging for SATUSEHAT integration
    |
    */

    'log_requests' => env('SATUSEHAT_LOG_REQUESTS', true),

    'log_responses' => env('SATUSEHAT_LOG_RESPONSES', true),

    'log_channel' => env('SATUSEHAT_LOG_CHANNEL', 'stack'),

];
