<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Regex;
use Zend\Router\Http\Segment;
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
                        'action' => 'index'
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'blog' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => 'blog[/]',
                            'defaults' => [
                                'action' => 'blog'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'view' => [
                                'type' => Regex::class,
                                'options' => [
                                    'regex' => '(?<id>[\d]+)-(?<slug>[a-zA-Z-_\d]+)\.html',
                                    'spec' => '%id%-%slug%.html',
                                    'defaults' => [
                                        'action' => 'view'
                                    ]
                                ],
                            ],
                        ]
                    ],
                ]
            ],
        ],
        'default_params' => [
            // Specify default parameters here for all routes here ...
        ]
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>
                InvokableFactory::class,
        ],
    ],

    'navigation' => [
        'default' => [
            'blog' => [
                'label' => _('Blogs'),
                'route' => 'home/blog'
            ],
        ],
    ],

    'view_manager' => [
        'template_map' => [
            // 'layout/layout' => __DIR__ . '/../../themes/default/view/layout/layout.phtml',
            // 'error/404' => __DIR__ . '/../../themes/default/view/error/404.phtml',
            // 'error/index' => __DIR__ . '/../../themes/default/view/error/index.phtml',
        ],
        'template_path_stack' => [
            // __DIR__ . '/../../themes/default/view',
        ],
    ],

    \MSBios\Assetic\Module::class => [
        'paths' => [
            __DIR__ . '/../../themes/default/public',
        ],
    ],
];
