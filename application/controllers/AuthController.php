<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('index', 'json')
            ->initContext();
    }

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

    public function logoutAction()
    {
        \Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('/points/');
    }
    
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
            return true;
        } else {
            return false;
        }
    }
    
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

