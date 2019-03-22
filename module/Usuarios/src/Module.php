<?php
/**
 * @link      http://github.com/zendframework/Usuarios for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuarios;

use Usuarios\Model\Dao\UsuarioDao;
use Zend\Config\Reader\Ini;
use Zend\Mvc\MvcEvent;

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

    public function getServiceConfig()
    {
        return [
            'factories' => [
                UsuarioDao::class => function ($sm) {
                    return new UsuarioDao();
                },
                'ConfigIni' => function ($sm) {
                    $reader = new Ini();
                    $data = $reader->fromFile(__DIR__ . '/../config/config.ini');
                    return $data;
                }
            ]
        ];
    }
}
