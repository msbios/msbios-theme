<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
return [
    'identifier' => 'default',
    'title' => 'Default Theme Title',
    'description' => 'Default Theme Description',

    'template_map' => [
        // Template Map
    ],

    'template_path_stack' => [
        __DIR__ . '/view/',
    ],

    'translation_file_patterns' => [
        [
            'type' => 'gettext',
            'base_dir' => __DIR__ . '/language/',
            'pattern' => '%s.mo',
        ],
    ],

    'widget_manager' => [
        'template_map' => [
            // Template Map
        ],
        'template_path_stack' => [
            __DIR__ . '/widget/'
        ],
    ],
];