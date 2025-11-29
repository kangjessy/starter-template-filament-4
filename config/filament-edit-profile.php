<?php

return [
    'locale_column' => 'locale',
    'theme_color_column' => 'theme_color',
    'avatar_column' => 'profile_photo_path',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public', // or replace by filesystem disk visibility with fallback value

    'show_custom_fields' => true,
    'custom_fields' => [
        'github' => [
            'label' => 'GitHub',
            'type' => 'text',
            'placeholder' => 'GitHub Username',
            'rules' => 'nullable|string|max:255',
            'required' => false,
        ],
    ],
];
