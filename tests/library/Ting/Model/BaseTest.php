<?php

namespace Ting\Model;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * _dummy 
     * 
     * @var Ting\Model\Dummy 
     * @access private
     */
    private $_dummy;
    /**
     * setUp 
     * 
     * @access public
     * @return void
     */
    public function setUp()
    {
        $this->_dummy = new DummyModel();
    }
    /**
     * testCanGetExistedProperty 
     * 
     * @access public
     * @return void
     */
    public function testCanGetExistedProperty()
    {
        $this->assertEquals('a', $this->_dummy->getPropertyOne());
    }

    /**
     * testCanGetNotInitializedProperty 
     * 
     * @access public
     * @return void
     */
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

    /**
     * testCanSetExistedProperty 
     * 
     * @access public
     * @return void
     * @depends testCanGetNotInitializedProperty
     */
    public function testCanSetExistedProperty()
    {
        $this->_dummy->setPropertyTwo('b');
        $this->assertEquals('b', $this->_dummy->getPropertyTwo());
    }
    /**
     * testUpdateValueOfAProperty 
     * 
     * @access public
     * @return void
     * @depends testCanGetNotInitializedProperty
     */
    public function testUpdateValueOfAProperty()
    {
        $this->_dummy->setPropertyOne('not a');
        $this->assertEquals('not a', $this->_dummy->getPropertyOne());
    }
    /**
     * testTryToSetNotExistedPropertyCausesException 
     * 
     * @access public
     * @return void
     */
    public function testTryToSetNotExistedPropertyCausesException()
    {
        try {
            $this->_dummy->setNoSuchProperty('whatever');
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
