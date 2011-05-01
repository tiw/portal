<?php

namespace Ting\Dal\DataMapper;

class UserPoint
{
    private $_dbTable;
    public function __construct($dbTable=null)
    {
        if(is_null($dbTable)) {
            $dbTable = new \Ting\Dal\DbTable\UserPoint();
        }
        $this->_dbTable = $dbTable;
    }
    /**
     * save user-point
     * 
     * @param \Ting\Model\Point $point 
     * @param \Ting\Model\User $user 
     * @param integer $position 
     * @access public
     * @return integer the id of the user-point
     */
    public function save($point, $user, $position)
    {
        $data = array(
            "id_user" => $user->getId(),
            "id_point" => $point->getId(),
            "position" => $position
        );
        $oldPosition = $this->findPosition($point, $user);
        if ($oldPosition === -1) {
            //save new
            return $this->_dbTable->insert($data);
        } else {
            //update
            $where = $this->_dbTable->getAdapter()
                ->quoteInto('id_user= ?', $user->getId()) .
                $this->_dbTable->getAdapter()
                ->quoteInto( ' AND id_point=?', $point->getId());
            return $this->_dbTable->update($data, $where);
        }

    }
    public function delete($point, $user)
    {
        $where = $this->_dbTable->getAdapter()
            ->quoteInto('id_user= ?', $user->getId()) .
            $this->_dbTable->getAdapter()
            ->quoteInto( ' AND id_point=?', $point->getId());
        return $this->_dbTable->delete($where);
    }
    /**
     * find position 
     * 
     * @param \Ting\Model\Point $point 
     * @param \Ting\Model\User $user 
     * @access public
     * @return mix, if no poistion found return -1, otherwise the poisition of
     *         user point
     */
    public function findPosition($point, $user)
    {
        $where = $this->_dbTable->getAdapter()
            ->quoteInto('id_user= ?', $user->getId()) .
            $this->_dbTable->getAdapter()
            ->quoteInto( ' AND id_point=?', $point->getId());
        $rows = $this->_dbTable->fetchAll($where);
        if (1 === count($rows)) {
            return $rows->current()->position;
        } elseif (0 === count($rows)) {
            return -1;
        } else {
            throw new \Exception("One user can have a point just one time");
        }
    }
}
