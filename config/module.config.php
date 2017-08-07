<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme;

return [
    'service_manager' => [
        'invokables' => [

            // Resolvers
            Resolver\DefaultThemeIdentifierResolver::class =>
                Resolver\DefaultThemeIdentifierResolver::class,

            Resolver\RouteThemeIdentifierResolver::class =>
                Resolver\RouteThemeIdentifierResolver::class,

            // listeners
            Listener\ThemeListener::class =>
                Listener\ThemeListener::class,
            Listener\LayoutListener::class =>
                Listener\LayoutListener::class,
        ],
        'factories' => [
            Module::class => Factory\ModuleFactory::class,

            // Managers
            ResolverManager::class => Factory\ResolverManagerFactory::class,
            ThemeManager::class => Factory\ThemeManagerFactory::class
        ],
    ],
    Module::class => [

        // default theme name if not set
        'default_theme_identifier' => 'default',

        // default layout name
        'default_layout_identifier' => 'layout/default',

        // default global path form themes
        'default_global_paths' => [
            './themes'
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

        // Module listeners
        'listeners' => [
            [
                'listener' => Listener\ThemeListener::class,
                'method' => 'onRender',
                'event' => \Zend\Mvc\MvcEvent::EVENT_RENDER,
                'priority' => 1,
            ], [
                'listener' => Listener\ThemeListener::class,
                'method' => 'onRender',
                'event' => \Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR,
                'priority' => 1,
            ], [
                'listener' => Listener\LayoutListener::class,
                'method' => 'onRender',
                'event' => \Zend\Mvc\MvcEvent::EVENT_DISPATCH,
                'priority' => 100,
            ], [
                'listener' => Listener\LayoutListener::class,
                'method' => 'onRender',
                'event' => \Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR,
                'priority' => 100,
            ]
        ],

        'themes' => [
            'default' => [
                'identifier' => 'default',
                'title' => 'Default Application Theme',
                'description' => 'Default Application Theme Descritpion',
                // Doctype with which to seed the Doctype helper
                // 'doctype' => $doctypeHelperConstantString, // e.g. HTML5, XHTML1
                // TemplateMapResolver configuration
                // template/path pairs
                'template_map' => [
                    // key => value
                ],
                // TemplatePathStack configuration
                // module/view script path pairs
                'template_path_stack' => [
                    __DIR__ . '/../themes/default/view',
                ],
                // Default suffix to use when resolving template scripts, if none, 'phtml' is used
                // 'default_template_suffix' => $templateSuffix, // e.g. 'php'
                // Controller namespace to template map
                // or whitelisting for controller FQCN to template mapping
                'controller_map' => [
                ],
                // Layout template name
                // 'layout' => $layoutTemplateName, // e.g. 'layout/layout'
                // ExceptionStrategy configuration
                // 'display_exceptions' => $bool, // display exceptions in template
                // 'exception_template' => $stringTemplateName, // e.g. 'error'
                // RouteNotFoundStrategy configuration
                // 'display_not_found_reason' => $bool, // display 404 reason in template
                // 'not_found_template' => $stringTemplateName, // e.g. '404'
                // Additional strategies to attach
                // These should be class names or service names of View strategy classes
                // that act as ListenerAggregates. They will be attached at priority 100,
                // in the order registered.
                'translation_file_patterns' => [
                    [
                        'type' => 'gettext',
                        'base_dir' => __DIR__ . '/../language/',
                        'pattern' => '%s.mo',
                    ],
                ],
            ],
        ],
    ],
];
