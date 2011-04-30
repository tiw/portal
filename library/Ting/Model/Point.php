<?php
/**
 * Model class for point.
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
 * Model class for Point 
 * 
 * @category Model
 * @package Ting/Model
 * @version $id$
 * @copyright ting wang <tting.wang@gmail.com>
 * @author Ting Wang 
 * @license  GPL
 */
class Point extends Base
{
    /**
     * _id 
     * 
     * id of the point
     * @var string
     */
    protected $_id;

    /**
     * _name 
     * 
     * Label of the point
     * @var string
     */
    protected $_name;

    /**
     * _logoUrl 
     * 
     * logo url of the point
     * @var string
     */
    protected $_logoUrl;

    /**
     * _link 
     * 
     * @var string
     * @access protected
     */
    protected $_link;
    /**
     * _position
     * 
     * oder of the point
     * @var integer
     */
    protected $_position;

    /**
     * _userId 
     * 
     * id of the owner
     * @var integer
     */
    protected $_userId;

    /**
     * _user 
     * 
     * owner of the point
     * @var Ting/Model/User
     */
    protected $_user;

    /**
     * _isPublic 
     * 
     * @var bool 
     * @access protected
     */
    protected $_isPublic;

}
