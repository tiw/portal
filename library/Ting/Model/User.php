<?php
/**
 * Model class for User.
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
 * Model class for User 
 * 
 * @category Model
 * @package Ting/Model
 * @version $id$
 * @copyright ting wang <tting.wang@gmail.com>
 * @author Ting Wang 
 * @license  GPL
 */
class User extends Base
{
    /**
     * _id 
     * 
     * id of the user
     * @var integer 
     */
    protected $_id;

    /**
     * _name 
     * 
     * name of the user
     * @var string
     */
    protected $_name;

    /**
     * _password 
     * 
     * password of the user
     * @var string
     */
    protected $_password;
}
