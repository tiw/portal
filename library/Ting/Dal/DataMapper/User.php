<?php

namespace Ting\Dal\DataMapper;

class User implements DataMapperInterface
{
    /**
     * _dbUser 
     * 
     * @var \Ting\Dal\DbTable\User
     * @access private
     */
    private $_dbUser;

    public function __construct() 
    { 
        $this->_dbUser = new \Ting\Dal\DbTable\User();
    }
    public function save()
    {
    }
    public function populate()
    {
    }
    public function getAll()
    {
    }
    public function getAllColumns()
    {
    }
    public function findById($id)
    {

    }
    /**
     * find user Id By Name 
     * 
     * @param string $name  name of the user
     * @access public
     * @return void
     */
    public function findIdByName($name)
    {
        var_dump($name);
        return $this->_dbUser->fetchAll(
            $this->_dbUser->select()->where('name=?', $name))->current();
    }
}
