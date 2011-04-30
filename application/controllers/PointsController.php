<?php

class PointsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('add', 'json')
            ->addActionContext('delete', 'json')
            ->addActionContext('change-order', 'json')
            ->initContext();
    }

    public function indexAction()
    {
        $this->view->points = array();
    }

    public function addAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function changeOrderAction()
    {
        // action body
    }


}







