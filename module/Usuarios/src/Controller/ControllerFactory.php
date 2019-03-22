<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 12:06
 */

namespace Usuarios\Controller;


use Usuarios\Model\Dao\UsuarioDao;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = null;
        switch ($requestedName){
            case IndexController::class :
                $usuarioDao = $container->get(UsuarioDao::class);
                $configIni = $container->get('ConfigIni');
                $controller = new IndexController($usuarioDao, $configIni);
                break;

            default:
                return (null === $options) ? new $requestedName: new $requestedName($options);
        }

        return $controller;
    }


}