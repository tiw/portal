<?php

namespace Ting\Dal\DataMapper;

/**
 * PointTest 
 * 
 * @category
 * @package 
 * @version $id$
 * @copyright 
 * @author Ting Wang 
 * @license 
 */
class PointTest extends \Ting\Test\DalTestBase
{
    /**
     * _pointMapper 
     * 
     * @var \Ting\Dal\DataMapper\Point
     */
    private $_pointMapper;

    public function setUp()
    {
        $this->_pointMapper = new Point();
        parent::setTestDataFile(__DIR__ . "/PointTestData.ini");
        parent::setUp();
    }
    /**
     * testFindById 
     * 
     * @access public
     * @return void
     */
    public function testFindById()
    {
        $id = $this->getInsertedId('point1');
        $point = $this->_pointMapper->findById($id);
        $this->assertEquals('foo', $point->getName());
    }
    /**
     * testSaveNewPoint 
     * 
     * @access public
     * @return void
     * @depends testFindById
     */
    public function testSaveNewPoint()
    {
        $point = new \Ting\Model\Point();
        $point->setName('bla');
        $point->setLink('http://bla/bar');
        $point->setPosition(1);
        $user = new \Ting\Model\User();
        $user->setId('1');
        $id = $this->_pointMapper->save($point, $user);
        $pointNew = $this->_pointMapper->findById($id);
        $this->assertEquals('bla', $pointNew->getName());
        $this->_pointMapper->delete($id);
    }
    /**
     * testUpdatePoint 
     * 
     * @access public
     * @return void
     * @depends testFindById
     */
    public function testUpdatePoint()
    {
        $id = $this->getInsertedId('point1');
        $point = $this->_pointMapper->findById($id);
        $point->setName('not foo');
        $user = new \Ting\Model\User();
        $user->setId($id);
        $this->_pointMapper->save($point, $user);
        $pointNew = $this->_pointMapper->findById($id);
        $this->assertEquals('not foo', $pointNew->getName());
    }
    /**
     * testFindAllPublicPoints 
     * 
     * @access public
     * @return void
     */
    public function testFindAllPublicPoints()
    {
        $points = $this->_pointMapper->findPublicPoints();
        $this->assertEquals(1, count($points));

    }

    /**
     * testUpdatePublicPointsGetException 
     * 
     * @access public
     * @return void
     */
    public function testUpdatePublicPointsGetException()
    {
        $id = $this->getInsertedId('point2');
        $point = new \Ting\Model\Point();
        $point->setId($id);

        $user = new \Ting\Model\User();
        $user->setId(1);
        try{
            $this->_pointMapper->save($point, $user);
            $this->assertTrue(false, "no exception");
        } catch (\Ting\Exception\Dal\DataMapper\PublicPointCannotBeChanged $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false, "not PublicPointCannotBeChanged excption ".
                $e->getMessage());
        }

    }
}
