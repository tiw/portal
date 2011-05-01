<?php

class PointsController extends Zend_Controller_Action
{

    private $_pointMapper;
    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('add', 'json')
            ->addActionContext('delete', 'json')
            ->addActionContext('change-order', 'json')
            ->initContext();
        $this->_pointMapper = new \Ting\Dal\DataMapper\Point();
        $this->_userPointMapper = new \Ting\Dal\DataMapper\UserPoint();
        $this->_user = new \Ting\Model\User();
        $this->_user->setId(1);
    }

    public function indexAction()
    {
        $points = $this->_pointMapper->findUsersPoints($this->_user);
        if (count($points) === 0) {
            $points = $this->_pointMapper->findPublicPoints();
            $i = 0;
            foreach ($points as $point) {
                // insert into user-point
                $this->_userPointMapper->save($point, $this->_user, $i);
                $i ++;
            }
        }
        $this->view->points = $points;
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $name = $request->getParam('name');
        $link = $request->getParam('link');
        $point = new \Ting\Model\Point();
        $point->setName($name);
        $point->setLink($link);
        $id = $this->_pointMapper->save($point, $this->_user);
        $this->view->id = $id;
    }

    public function deleteAction()
    {
        // action body
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $point = $this->_pointMapper->findById($id);
        if(!is_null($point)) {
            $this->_pointMapper->delete($point);
            $this->_userPointMapper->delete($point, $user);
        }
    }

    public function changeOrderAction()
    {
        $request = $this->getRequest();
        $idPositions = $request->getParam('positions');
        $this->_pointMapper->updatePosition($idPositions, $this->_user);
        // action body
    }


}







