<?php
namespace Usuarios;

use Usuarios\Controller\ControllerFactory;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => ControllerFactory::class,
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
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Usuarios' => __DIR__ . '/../view',
        ],
    ],
];
