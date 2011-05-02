<?php

/**
 * auth controller
 * mangage the authentification of the user
 *
 * PHP version 5.3
 *
 * @category Controller
 * @package Controller
 * @version $id$
 * @copyright ting wang <tting.wang@gmail.com>
 * @author Ting Wang 
 * @license  
 */
class AuthController extends Zend_Controller_Action
{

    /**
     * init 
     * 
     * @access public
     * @return void
     */
    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('index', 'json')
            ->initContext();
    }

    /**
     * indexAction 
     * 
     * @access public
     * @return void
     */
    public function indexAction()
    {
        $request = $this->getRequest();

        if($request->isPost()) {
            if ($this->_process($request->getPost())) {
                // successfully login
                $this->view->status = 1;
            } else {
                $this->view->status = 0;
            }
        }       
    }

    /**
     * logoutAction 
     * 
     * @access public
     * @return void
     */
    public function logoutAction()
    {
        \Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('/points/');
    }
    
    /**
     * _process 
     * 
     * @param mixed $values 
     * @access protected
     * @return void
     */
    protected function _process($values)
    {
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['user_name']);
        $adapter->setCredential($values['password']);

        $auth = \Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $row = $adapter->getResultRowObject();
            $user = new \Ting\Model\User();
            $user->setName($row->name);
            $user->setId($row->id);
            $auth->getStorage()->write($user);
            if (1 == $values[ 'rememberme' ]) {
                $seconds = 60 * 60 * 24 * 14; // 8 days
                Zend_Session::rememberMe($seconds);
            }
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * _getAuthAdapter 
     * 
     * @access protected
     * @return void
     */
    protected function _getAuthAdapter()
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName('user')
                    ->setIdentityColumn('name')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('MD5(?)');

        return $authAdapter;
    }


}

