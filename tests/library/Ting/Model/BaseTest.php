<?php

namespace Ting\Model;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    private $_dummy;
    public function setUp()
    {
        $this->_dummy = new DummyModel();
    }
    public function testCanGetExistedProperty()
    {
        $this->assertEquals('a', $this->_dummy->getPropertyOne());
    }

    public function testCanGetNotInitializedProperty()
    {
        $this->assertEquals(null, $this->_dummy->getPropertyTwo());
    }

    /**
     * testTryToGetNotExistedPropertyCausesException 
     * 
     * @access public
     * @return void
     */
    public function testTryToGetNotExistedPropertyCausesException()
    {
        try {
            $this->_dummy->getNoSuchProperty();
            $this->assertTrue(false, "Should throw an exception");
        } catch(\Ting\Exception\Model\NoSuchPropertyException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false, "Exception is not NoSuchPropertyException");
        }
    }
}
class DummyModel extends Base
{
    protected $_propertyOne = 'a';
    protected $_propertyTwo;
}
