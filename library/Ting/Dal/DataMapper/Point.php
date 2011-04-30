<?php

namespace Ting\Dal\DataMapper;
use \Ting\Dal\DbTable\Point as DbPoint;
use \Ting\Dal\DbTable\UserPoint as DbUserPoint;


class Point
{
    private $_dbTable;
    
    public function __construct($dbTable = null)
    {
       if (is_null($dbTable))
            $dbTable = new DbPoint();
        $this->_dbTable = $dbTable;
    }
    /**
     * save 
     *  save a point
     *  just private point can be saved
     *  public point is protected
     * @param mixed $point 
     * @access public
     * @return void
     */
    public function save($point)
    {
        $data = array(
            "name" => $point->getName(),
            "link" => $point->getLink(),
            "logo_url" => $point->getLogoUrl(),
            "position" => $point->getPosition(),
        );
        if (is_null($point->getId())) {
            return $this->_dbTable->insert($data);
        } else {
            if ($this->isPublic($point)) {
                throw new 
                    \Ting\Exception\Dal\DataMapper\PublicPointCannotBeChanged();
            }
            $where = $this->_dbTable
                ->getAdapter()->quoteInto('id = ?', $point->getId());
            return $this->_dbTable
                ->update($data, $where);
        }
    }
    public function isPublic($point)
    {
        $point = $this->findById($point->getId());
        return (1 == $point->getIsPublic());
    }
    public function findById($id)
    {
        $row = $this->_dbTable->find($id)->current();
        return $this->_rowToObject($row);
    }
    private function _rowToObject($row)
    {
        if (!is_null($row)) {
            $point = new \Ting\Model\Point();
            $point->setId($row->id)
                  ->setName($row->name)
                  ->setLink($row->link)
                  ->setLogoUrl($row->logo_url)
                  ->setPosition($row->position)
                  ->setIsPublic($row->is_public);
            return $point;
        }
        return null;
    }
    public function findUsersPoints($user)
    {
        $points = array();
        $userPointTable = new DbUserPoint();
        $select = $userPointTable->select()->where('id_user= ?', $user->getId());
        $rows = $table->fetchAll($select);
        foreach($rows as $row) {
            $points[] = $this->findById($row->id_point);
        }
        return $points;
    }
    public function findPublicPoints()
    {
        $publicPoints = array();
        $select = $this->_dbTable->select()->where('is_public=?', 1);
        $rows = $this->_dbTable->fetchAll($select);
        foreach($rows as $row) {
            $point = $this->_rowToObject($row);
            if (!is_null($point)) {
                $publicPoints[] = $point;
            }
        }
        return $publicPoints;
    }
    public function delete($id)
    {
        $where = $this->_dbTable->getAdapter()->quoteInto('id = ?', $id);
        return $this->_dbTable->delete($where);
    }
}
