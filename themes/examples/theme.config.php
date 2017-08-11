<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
return [
    'identifier' => 'examples',
    'title' => 'Default Examples Theme',
    'description' => 'Default Examples Theme Description',
    'template_map' => [
        'example/example' => __DIR__ . '/path/to/file'
    ],
    'template_path_stack' => [
        __DIR__ . '/path/to/file/',
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
            'example/example' => __DIR__ . '/path/to/file'
        ],
        'template_path_stack' => [
            __DIR__ . '/path/to/file/',
        ],
    ],
];