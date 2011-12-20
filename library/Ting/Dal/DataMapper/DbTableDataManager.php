<?php


namespace \Ting\Dal\DataMapper;

class DbTableDataManager implements DataMapperInterface
{

    
    private function _getColumnName($model)
    {

        foreach ($model->getProperties() as $property) {

        }
    }
    /**
     * save
     * 
     * @param mixed $model 
     * @return void
     */
    public function save($model)
    {
        $data = array();
        foreach ($this->getProperties() as $property) {
            $columnName    = '';
            $getMethodName = '';
            $data[$columnName] = $this->$getMethodName();
        }
        if (is_null($model->getId())) {
            $id = $this->_dbTable->insert($data);
            return $id;
        } else {
            $where = $this->_dbTable
                ->getAdapter()->quoteInto('id = ?', $point->getId());
            return $this->_dbTable
                ->update($data, $where);
        }
    }

    public function findById($id)
    {
    }
}
