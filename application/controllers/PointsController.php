<?php

class PointsController extends Zend_Controller_Action
{

    private $_pointMapper;
    public function init()
    {
        $this->_helper->contextSwitch()
            ->addActionContext('delete', 'json')
            ->addActionContext('change-order', 'json')
            ->initContext();
        $this->_pointMapper = new \Ting\Dal\DataMapper\Point();
        $this->_userPointMapper = new \Ting\Dal\DataMapper\UserPoint();
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity()) {
            $this->_user = $auth->getIdentity(); 
        }
    }

    public function indexAction()
    {
        $login = false;
        $points = array();
        if (\Zend_Auth::getInstance()->hasIdentity()) {
            $login = true;
            $points = $this->_pointMapper->finduserspoints($this->_user);
            if (count($points) === 0) {
                $points = $this->_pointMapper->findPublicPoints();
                $i = 0;
                foreach ($points as $point) {
                    // insert into user-point
                    $this->_userPointMapper->save($point, $this->_user, $i);
                    $i ++;
                }
            }
        }

        $this->view->points = $points;
        $this->view->login = $login;
    }

    public function getListAction()
    {
        $points = $this->_pointMapper->finduserspoints($this->_user);
        foreach($points as $point){
            echo "<li id = \"points-{$point->getId()}\" class=\"points\">";
            echo "<div class=\"text\"> ";
            echo "<a href=\"{$point->getLink()}\">{$point->getName()}</a>";
            echo "</div>";
            if($point->getIsPublic() != 1) {
                echo "<div class=\"actions\">";
                echo "<a href=\"#\" class=\"delete\">Delete</a>";
                echo "</div>";
            }
            echo "</li>";
        }
        die;
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
        $point = <<<EOF
<li id="points-{$id}" class="points">
  <div class="text"><a href="{$point->getLink()}">{$point->getName()}</a></div>
  <div class="actions">
    <a href="#" class="delete">Delete</a>
   </div>
</li>
EOF;
        echo $point;die;
    }

    public function deleteAction()
    {
        // action body
        $request = $this->getRequest();
        $id = $request->getParam('id');
        $point = $this->_pointMapper->findById($id);
        if(!is_null($point)) {
            $this->_pointMapper->delete($point);
            $result = $this->_userPointMapper->delete($point, $this->_user);
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







