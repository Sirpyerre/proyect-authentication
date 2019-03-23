<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 22/03/19
 * Time: 17:56
 */

namespace Catalogo;


use Catalogo\Controller\IndexController;
use Catalogo\Model\Dao\IProductoDao;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = null;

        switch ($requestedName){
            case IndexController::class:
                $productoDao = $container->get(IProductoDao::class);
                $controller = new IndexController($productoDao);
                break;

            default:
                return(null === $options) ? new $requestedName : new $requestedName($options);
        }

        return $controller;
    }


}