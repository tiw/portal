<?php
/**
 * Check whether the user is login.
 *
 * PHP version 5.3
 *
 * @category Ting
 * @package  Ting
 * @author   Ting Wang
 * @license  
 */

namespace Ting\Controller\Plugin;

/**
 * Check whether the user is login.
 *
 * @category Ting
 * @package  Ting
 * @author   Ting Wang 
 * @license  
 */
class AuthPlugin extends \Zend_Controller_Plugin_Abstract
{
    /**
     * Check the whether user login
     *
     * @param \Zend_Controller_Request_Abstract $request 
     *
     * @return void
     */
    public function dispatchLoopStartup(
        \Zend_Controller_Request_Abstract $request
    ) {
        //var_dump(\Zend_Auth::getInstance());
        $request =  \Zend_Controller_Front::getInstance()->getRequest();
        if ($request->getControllerName() == 'points'
            && $request->getActionName() == 'index'
        ) {
        } else {
            if (!\Zend_Auth::getInstance()->hasIdentity()) {
                $requested = \Zend_Controller_Front::getInstance()
                    ->getRequest()->getRequestUri();
                $base = \Zend_Controller_Front::getInstance()->getBaseUrl();
                $redirUri = str_replace($base, '', $requested);
                \Zend_Session::start();

                //Create session namespace
                $prevSession = new \Zend_Session_Namespace('prevUri');

                //store requested url
                $prevSession->uri = $redirUri;

            } 
        }
    }
}
