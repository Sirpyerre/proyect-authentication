<?php
/**
 * @link      http://github.com/zendframework/Usuarios for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuarios;

use Usuarios\Model\Dao\IUsuario;
use Usuarios\Model\Dao\UsuarioDao;
use Usuarios\Model\Entity\Usuario;
use Usuarios\Model\Login;
use Zend\Authentication\AuthenticationService;
use Zend\Config\Reader\Ini;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\MvcEvent;
use Application\Controller\IndexController as HomeController;
use Zend\ServiceManager\Factory\InvokableFactory;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
//
//    public function init($mm)
//    {
//        $eventManager = $mm->getEventManager();
//        $sharedEvents = $eventManager->getSharedManager();
//        $sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_BOOTSTRAP, [$this, 'initConfig']);
//    }
//
//    public function setLayout($e){
//        $viewModel = $e->getViewModel();
//        $viewModel->setTemplate('layout/layout_otro');
//    }
//
    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
//        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'initConfig']);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initViewRender']);
//        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initEnviroment']);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initAuth'], 100);
    }

    public function initViewRender(MvcEvent $e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $viewRender = $sm->get('ViewRenderer');
        $config = $sm->get('ConfigIni');

        $viewRender->headTitle($config['parametros']['titulo']);
        $viewRender->headMeta()->setCharset($config['parametros']['view']['charset']);
        $viewRender->doctype($config['parametros']['view']['doctype']);
    }

    public function initAuth(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $auth = $serviceManager->get(Login::class);

        $layout = $e->getViewModel();
        $layout->auth = $auth;

        $matches = $e->getRouteMatch();
        $controllerName = $matches->getParam('controller');
        $action = $matches->getParam('action');

        switch ($controllerName) {
            case Controller\LoginController::class:
                if (in_array($action, ['index', 'autenticar'])) {
                    return;
                }
                break;

            case HomeController::class:
                if (in_array($action, ['index'])) {
// Validamos cuando el controlador sea Index (Home)
// exepto las acciones index.
                    return;
                }
                break;
        }

        if (!$auth->isLoggedIn()) {
// No existe Session, redirigimos al login.
            $matches->setParam('controller', Controller\LoginController::class);
            $matches->setParam('action', 'index');
        }
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'UsuariosTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Usuario());
                    return new TableGateway('usuarios', $dbAdapter, null, $resultSetPrototype);
                },
                IUsuario::class => function ($sm) {
                    $tableGateway = $sm->get('UsuariosTableGateway');
                    $dao = new UsuarioDao($tableGateway);
                    return $dao;
                },
                Login::class => function ($sm) {
                    $dbAdapter = $sm->get(AdapterInterface::class);
                    return new Login($dbAdapter);
                },
                'ConfigIni' => function ($sm) {
                    $reader = new Ini();
                    $data = $reader->fromFile(__DIR__ . '/../config/config.ini');
                    return $data;
                },
                AuthenticationService::class => InvokableFactory::class
            ],
            'aliases' =>[
                'auth_service' => AuthenticationService::class
            ]
        ];
    }
}
