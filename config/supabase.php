<?php

return [

    'url' => env('SUPABASE_URL'),

    'anon_key' => env('SUPABASE_ANON_KEY'),

    'service_role_key' => env('SUPABASE_SERVICE_ROLE_KEY'),

    /*
    | When enabled, admin login is verified through Supabase Auth API.
    | Passwords are managed in Supabase Dashboard → Authentication → Users.
    */
    'auth_enabled' => env('SUPABASE_AUTH_ENABLED', false),

    /*
    | Comma-separated list of emails allowed to access the admin panel.
    | The user must also exist and authenticate in Supabase when auth is enabled.
    */
    'admin_emails' => array_values(array_filter(array_map(
        'trim',
        explode(',', (string) env('SUPABASE_ADMIN_EMAILS', ''))
    ))),

];
