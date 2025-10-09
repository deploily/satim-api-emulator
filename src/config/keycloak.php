<?php

return [
    'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY', null),

    'token_encryption_algorithm' => env('KEYCLOAK_TOKEN_ENCRYPTION_ALGORITHM', 'RS256'),

    'load_user_from_database' => env('KEYCLOAK_LOAD_USER_FROM_DATABASE', true),

    'user_provider_custom_retrieve_method' => env('KEYCLOAK_USER_PROVIDER_CUSTOM_RETRIEVE_METHOD', null),

    'user_provider_credential' => env('KEYCLOAK_USER_PROVIDER_CREDENTIAL', 'username'),

    'client_secret' => env('KEYCLOAK_CLIENT_SECRET', null),

    'client_id' => env('KEYCLOAK_CLIENT_ID'),
  'redirect_uri' => env('KEYCLOAK_REDIRECT_URI'),

    'base_url' => env('KEYCLOAK_BASE_URL'),
    'realm' => env('KEYCLOAK_REALM'),
    'token_principal_attribute' => env('KEYCLOAK_TOKEN_PRINCIPAL_ATTRIBUTE', 'preferred_username'),

    'append_decoded_token' => env('KEYCLOAK_APPEND_DECODED_TOKEN', false),

    'allowed_resources' => env('KEYCLOAK_ALLOWED_RESOURCES', null),

    'ignore_resources_validation' => env('KEYCLOAK_IGNORE_RESOURCES_VALIDATION', false),

    'leeway' => env('KEYCLOAK_LEEWAY', 0),

    'input_key' => env('KEYCLOAK_TOKEN_INPUT_KEY', null)
];
