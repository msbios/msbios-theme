<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme;

use MSBios\Factory\ModuleFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'widget_manager' => [
        'factories' => [
            Widget\FollowDevelopmentWidget::class =>
                InvokableFactory::class
        ],
    ],

    'service_manager' => [
        'factories' => [

            Module::class =>
                ModuleFactory::class,

            ResolverManager::class =>
                Factory\ResolverManagerFactory::class,

            // Resolvers
            Resolver\DefaultThemeIdentifierResolver::class =>
                InvokableFactory::class,
            Resolver\RouteThemeIdentifierResolver::class =>
                InvokableFactory::class,

            // Listener
            ListenerAggregate::class =>
                InvokableFactory::class
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
    ],

    Module::class => [

        // config cache enabled
        'config_cache_enabled' => false,

        // config cache key
        'config_cache_key' => 'themes.config.cache',

        // cache dir
        'cache_dir' => 'data/cache/',

        // default theme name if not set
        'default_theme_identifier' => 'default',

        // default layout name
        'default_layout_identifier' => 'layout/layout',

        // default global path form themes
        'default_global_paths' => [
            'default_global_paths' => './themes'
        ],

        // default config filename in theme folder
        'default_config_filename' => 'theme.config.php',

        // theme resolvers
        'resolvers_configuration_themes' => [
            Resolver\DefaultThemeIdentifierResolver::class => -100700,
            Resolver\RouteThemeIdentifierResolver::class => -100500,
        ],

        // layout resolvers
        'resolvers_configuration_layouts' => [
            Resolver\RouteLayoutIdentifierResolver::class => -100700
        ],

        'themes' => [
            'default' => [
                'identifier' => 'default',
                'title' => 'Default Theme Title',
                'description' => 'Default Theme Description',

                'template_map' => [
                    // ...
                ],

                'template_path_stack' => [
                    __DIR__ . '/../themes/default/view/',
                ],

                'translation_file_patterns' => [
                    [
                        'type' => 'gettext',
                        'base_dir' => __DIR__ . '/../themes/default/language/',
                        'pattern' => '%s.mo',
                    ],
                ],

                'widget_manager' => [
                    'template_map' => [
                        // Template Map
                    ],
                    'template_path_stack' => [
                        __DIR__ . '/../themes/default/widget/'
                    ],
                ],
            ]
        ],
    ],

    'listeners' => [
        ListenerAggregate::class
    ]
];
