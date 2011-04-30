<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initAutoloader()
    {
        $this->getApplication()->getAutoloader()->registerNamespace('Ting');
    }        

}

