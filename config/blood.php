<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Session & Eligibility Policies
    |--------------------------------------------------------------------------
    */

    // How long a donation session stays "Active" before it auto-expires (minutes).
    'session_timeout_minutes' => 30,

    // Minimum age to donate (years).
    'minimum_age_donate' => 18,

    // Maximum age to donate (years).
    'maximum_age_donate' => 65,

    // Minimum weight to donate (kg).
    'minimum_weight' => 50,

    // Deferral period after a whole-blood donation (by gender, in days).
    'donation_deferral' => [
        'whole_blood' => [
            'male_days' => 90,
            'female_days' => 120,
            'other_days' => 90,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Donor Detail Sharing
    |--------------------------------------------------------------------------
    */

    // Donor can share contact only while session is in this status.
    'shareable_session_statuses' => ['Active', 'Completed'],

    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    */

    // Which models should be tracked by the audit log.
    'audit_log_models' => [
        'BloodRequest',
        'DonationSession',
        'Donor',
        'BloodGroup',
        'BloodStock',
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Defaults
    |--------------------------------------------------------------------------
    */

    'donor_badges' => [
        1 => 'Bronze Donor',
        5 => 'Silver Donor',
        10 => 'Gold Donor',
        25 => 'Platinum Donor',
    ],

    'availability_statuses' => [
        'Available',
        'Busy',
        'Waiting',
        'Unavailable',
    ],

];
