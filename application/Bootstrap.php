<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initAutoloader()
    {
        $this->getApplication()->getAutoloader()->registerNamespace('Ting');
    }        
    public function _initPlugin()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $authPlugin = new \Ting\Controller\Plugin\AuthPlugin();
        $frontController->registerPlugin($authPlugin);
    }
}

