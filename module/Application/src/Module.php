<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Config\Reader\Ini;
use Zend\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
//        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'initConfig']);
//        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initViewRender']);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'initEnviroment']);
    }



    public function initEnviroment(MvcEvent $e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $config = $sm->get('ConfigIni');
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', true);

        $timeZone = (string) $config['parametros']['timezone'];

        if(empty($timeZone)){
            $timeZone = 'America/Mexico_city';
        }

        date_default_timezone_set($timeZone);
    }

    public function initConfig(MvcEvent $e)
    {
        $application = $e->getApplication();
        $services = $application->getServiceManager();
        $services->setFactory('ConfigIni', function ($services){
           $reader = new Ini();
           $data = $reader->fromFile(__DIR__ . '/../config/config.ini');
           return $data;
        });
    }

//    public function getServiceConfig()
//    {
//        return [
//            'factories' => [
//                UsuarioDao::class => function($sm){
//                    return new UsuarioDao();
//                },
//                'ConfigIni' => function($sm){
//                    $reader = new Ini();
//                    $data = $reader->fromFile(__DIR__.'/../config/config.ini');
//                    return $data;
//                }
//            ]
//        ];
//    }
}
