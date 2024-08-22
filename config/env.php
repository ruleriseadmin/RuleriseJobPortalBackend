<?php

return [
    'candidate' => [
        'reset_password_url' => env('CANDIDATE_RESET_PASSWORD_URL'),
        'base_url' => env('CANDIDATE_BASE_URL'),
        'login_url' => env('CANDIDATE_LOGIN_URL'),
        'profile_url' => env('CANDIDATE_PROFILE_URL'),
        'verify_email_url' => env('CANDIDATE_VERIFY_EMAIL_URL'),
    ],
    'employer' => [
        'reset_password_url' => env('EMPLOYER_RESET_PASSWORD_URL'),
        'login_url' => env('EMPLOYER_LOGIN_URL'),
        'profile_url' => env('EMPLOYER_PROFILE_URL'),
        'verify_email_url' => env('EMPLOYER_VERIFY_EMAIL_URL'),
    ],
];
