<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
return [
    'identifier' => 'examples',
    'title' => 'Default Examples Theme',
    'description' => 'Default Examples Theme Descritpion',
    'template_map' => [
        'somename/somename' => __DIR__ . '/view/path/to/file'
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
    'assetic_manager' => [

        'collections' => [
        ],

        'paths' => [
        ],

        'maps' => [
        ],
    ],
    'widget_manager' => [
        'template_map' => [
            'somename/somename' => __DIR__ . '/view/path/to/file'
        ],
        'template_path_stack' => [
            __DIR__ . '/view/',
        ],
    ],
];