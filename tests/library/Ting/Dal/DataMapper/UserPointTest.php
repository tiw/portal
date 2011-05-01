<?php

namespace Ting\Dal\DataMapper;

/**
 * UserPointTest 
 * 
 * @category
 * @package 
 * @version $id$
 * @copyright 
 * @author Ting Wang 
 * @license 
 */
class UserPointTest extends \Ting\Test\DalTestBase
{
    private $_userPointMapper;
    public function setUp()
    {
        $this->_userPointMapper = new UserPoint();
        parent::setTestDataFile(__DIR__ . "/UserPointTestData.ini");
        parent::setUp();
    }    

    public function testFindPoistion()
    {
        $user = new \Ting\Model\User();
        $user->setId(1);
        $point = new \Ting\Model\Point();
        $point->setId(1);
        $this->assertEquals(1,
            $this->_userPointMapper->findPosition($point, $user));
    }

    /**
     * testUpdataExistedUserPoint 
     * 
     * @access public
     * @return void
     * @depends testFindPoistion
     */
    public function testUpdataExistedUserPoint()
    {
        $user = new \Ting\Model\User();
        $user->setId(1);
        $point = new \Ting\Model\Point();
        $point->setId(1);
        $this->_userPointMapper->save($point, $user, 2);
        $this->assertEquals(2,
            $this->_userPointMapper->findPosition($point, $user));

    }
    /**
     * deleteUserPoint 
     * 
     * @access public
     * @return void
     * @depends testFindPoistion
     */
    public function deleteUserPoint()
    {
        $user = new \Ting\Model\User();
        $user->setId(1);
        $point = new \Ting\Model\Point();
        $point->setId(1);
        $this->_userPointMapper->delete($point, $user);
        $this->assertEquals(-1,
            $this->_userPointMapper->findPosition($point, $user));
    }
    /**
     * testAddNewUserPoint 
     * 
     * @access public
     * @return void
     * @depends testFindPoistion
     */
    public function testAddNewUserPoint()
    {
        $user = new \Ting\Model\User();
        $user->setId(2);
        $point = new \Ting\Model\Point();
        $point->setId(1);
        $id = $this->_userPointMapper->save($point, $user, 3);
        $this->assertEquals(3,
            $this->_userPointMapper->findPosition($point, $user));
        $this->_userPointMapper->delete($point, $user);
    }
}

