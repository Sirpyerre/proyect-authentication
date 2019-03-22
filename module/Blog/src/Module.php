<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog;

use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'setLayout']);
    }

//
//    public function init($mm)
//    {
//        $eventManager = $mm->getEventManager();
//        $sharedEvents = $eventManager->getSharedManager();
//        $sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, [$this, 'setLayout']);
//    }
//
    public function setLayout($e)
    {
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        if(0 !== strpos($controller, __NAMESPACE__, 0)){
            return;
        }

        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('layout/layout_otro');
    }
//
//    public function initConfig()
//    {
//
//    }
}
