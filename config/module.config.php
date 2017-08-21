<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme;

use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
        'default_params' => [
            // Specify default parameters here for all routes here ...
        ]
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],

    'service_manager' => [
        'invokables' => [
            // Resolvers
            Resolver\DefaultThemeIdentifierResolver::class,
            Resolver\RouteThemeIdentifierResolver::class,
            // listeners
            Listener\ThemeListener::class,
            Listener\LayoutListener::class,


            // widgets
            Widget\FollowDevelopmentWidget::class
        ],
        'factories' => [
            Module::class => Factory\ModuleFactory::class,

            // Managers
            ResolverManager::class => Factory\ResolverManagerFactory::class,
            ThemeManager::class => Factory\ThemeManagerFactory::class
        ],
    ],

     'view_manager' => [
         'display_not_found_reason' => true,
         'display_exceptions' => true,
         'doctype' => 'HTML5',
         'not_found_template' => 'error/404',
         'exception_template' => 'error/index',
         'template_map' => [
            // 'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            // 'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            // 'error/404' => __DIR__ . '/../view/error/404.phtml',
            // 'error/index' => __DIR__ . '/../view/error/index.phtml',
         ],
         'template_path_stack' => [
             __DIR__ . '/../themes/default/view/',
             __DIR__ . '/../themes/default/widget/',
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
                'method' => 'onDispatch',
                'event' => \Zend\Mvc\MvcEvent::EVENT_DISPATCH,
                'priority' => 1,
            ], [
                'listener' => Listener\LayoutListener::class,
                'method' => 'onDispatch',
                'event' => \Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR,
                'priority' => 1,
            ]
        ],

        'themes' => [
            // Some Themes
        ],
    ],
];
