<?php
/**
 * Base model
 *
 * PHP version 5.3
 *
 * @category Model
 * @package Ting/Model
 * @version $id$
 * @copyright ting wang <tting.wang@gmail.com>
 * @author Ting Wang 
 * @license  GPL
 */

namespace Ting\Model;
/**
 * Base model
 * 
 * @category Model
 * @package Ting/Model
 * @version $id$
 * @copyright ting wang <tting.wang@gmail.com>
 * @author Ting Wang 
 * @license  GPL
 */

class Base
{

    /**
     * __construct 
     * 
     * @param array $params key is the property name without _, value is the
     *                      value of the property.
     * @access public
     * @return void
     */
    public function __construct($params = null)
    {
        if (!is_null($params)) {
            foreach($params as $key => $value) {
                $property = "_" . $key;
                if($this->_isProperty($property)) {
                    $method = "set" . ucfirst($key);
                    $this->$method($value);
                }
            }
        }
    }
    /**
     * __call 
     * dynamic get/set properties
     * 
     * @param string $method 
     * @param array $args 
     * @access public
     * @return mix 
     */
    public function __call($method, $args)
    {
        $prefix = substr($method, 0, 3);
        $property = "_" . lcfirst(substr($method, 3));


        if (!$this->_isProperty($property)) {
            throw new \Ting\Exception\Model\NoSuchPropertyException($property);
        }

        if ($prefix == "get" && (isset($this->$property) 
            || is_null($this->$property))
        ) {
            return $this->$property;
        }

        if ($prefix == "set" && $this->_isProperty($property)) {
            $this->$property = $args[0];
            return $this;
        }
        throw new \Exception("can not get/set property " . $property);
    }
    private function _isProperty($property)
    {
        $isProperty=false;
        if(array_key_exists($property, get_object_vars($this))) {
            $isProperty = true;
        }
        return $isProperty;
    }
}
