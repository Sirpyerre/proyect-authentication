<?php
namespace Usuarios;

use Usuarios\Controller\ControllerFactory;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ControllerFactory::class,
            Controller\LoginController::class => ControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'usuario' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/usuario[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'listar',
                    ],
                ],
            ],
            'login' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/login[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'login',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Usuarios' => __DIR__ . '/../view',
        ],
    ],
];
