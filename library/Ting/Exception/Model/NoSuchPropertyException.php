<?php
/**
 * NoSuchPropertyException 
 * 
 * PHP version 5.3
 *
 * @category Exception
 * @package  Exception/Model
 * @version $id$
 * @copyright 
 * @author Ting Wang 
 * @license 
 */
namespace Ting\Exception\Model;
/**
 * NoSuchPropertyException 
 * 
 * @category Exception
 * @package  Exception/Model
 * @version $id$
 * @copyright 
 * @author Ting Wang 
 * @license 
 */
class NoSuchPropertyException extends \Exception 
{
    public function __construct($propertyName)
    {
        $this->message = $propertyName . " is not an property";
    }
}
