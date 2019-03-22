<?php
/**
 * @link      http://github.com/zendframework/Usuarios for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuarios;

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
//    public function initConfig()
//    {
//
//    }
}
