<?php

return [
    'strings'     => [
        'plugin_desc'               => 'Adds browser\'s language detection and language route prefixes to the Rainlab\'s Translate plugin.',
        'settings_label'            => 'Translate Extended Settings',
        'settings_desc'             => 'Manage the settings for the Translate Extended.',
        'browser_language_detection'           => 'Browser language detection',
        'browser_language_detection_comment'   => 'Enables translating website in the preferred browser language.',
        'route_prefixing'            => 'Route prefixing',
        'route_prefixing_comment'    => 'Enables locale prefixes in the route URL.',
        'prefer_user_session'           => 'Prefer user session over auto detected language',
        'prefer_user_session_comment'   => 'If enabled, language set in user session will have priority over preferred browser language. If disabled locale will be detected every time user re-enters the website.',
        'homepage_redirect'             => 'Homepage redirect',
        'homepage_redirect_comment'     => 'If enabled, locale shortcode will be added to homepage URL.'
    ],
    'permissions' => [
        'tab'      => 'Excodus',
        'settings' => 'Access settings',
    ],
];
