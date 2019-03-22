<?php
namespace Blog;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\BlogController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'blog' => [
                'type'    => Segment::class,
                'options' => [
                    // Change this to something specific to your module
                    'route'    => '/blog[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller'    => Controller\BlogController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Blog' => __DIR__ . '/../view',
        ],
    ],
];
