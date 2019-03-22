<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 12:06
 */

namespace Application\Controller;


use Application\Model\Dao\UsuarioDao;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = null;
        switch ($requestedName){
            case UsuarioController::class :
                $usuarioDao = $container->get(UsuarioDao::class);
                $configIni = $container->get('ConfigIni');
                $controller = new UsuarioController($usuarioDao, $configIni);
                break;

            default:
                return (null === $options) ? new $requestedName: new $requestedName($options);
        }

        return $controller;
    }


}