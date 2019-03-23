<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 12:06
 */

namespace Usuarios\Controller;

use Interop\Container\ContainerInterface;
use Usuarios\Model\Dao\IUsuario;
use Zend\ServiceManager\Factory\FactoryInterface;
use Usuarios\Model\Login;

class ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = null;
        switch ($requestedName){
            case IndexController::class :
                $usuarioDao = $container->get(IUsuario::class);
                $configIni = $container->get('ConfigIni');
                $controller = new IndexController($usuarioDao, $configIni);
                break;

            case LoginController::class :
                $login = $container->get(Login::class);
                $controller = new LoginController($login);
                break;

            default:
                return (null === $options) ? new $requestedName: new $requestedName($options);
        }

        return $controller;
    }


}