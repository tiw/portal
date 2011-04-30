<?php

namespace Ting\Test;

/**
 * base test class for testing dal 
 **/
class DalTestBase extends \PHPUnit_Framework_TestCase
{
    private $_testDataFile;

    public function setUp()
    {
        $this->insertTestData();
    }
    public function tearDown()
    {
        $this->removeTestData();
        $this->_closeDatabaseConnection();
    }
        /**
     * Get the id of inserted object in ini file.
     *
     * @param string $name the name of the test data in ini file.
     *
     * @return int
     */
    public function getInsertedId($name)
    {
        if (array_key_exists($name, $this->_insertedIds)) {
            return $this->_insertedIds[$name];
        } else {
            throw new \Exception(
                'no test data is found with the name ' . $name
            );
        }
    }

    /**
     * Close the database connection.
     *
     * @return void
     */
    private function _closeDatabaseConnection()
    {
        $db = \Zend_Db_Table::getDefaultAdapter();
        if (is_object($db)) {
            $db->closeConnection();
        }
    }

    public function setTestDataFile($file)
    {
        $this->_testDataFile = $file;
    }
    public function getTestDataFile()
    {
        return $this->_testDataFile;
    }


    /**
     * Remove the test data in the test data file from database.
     *
     * @return void
     */
    protected function removeTestData() 
    {
        $config = $this->_readTestDataFile();
        if ($config) {
            foreach ($config->toArray() as $dataName => $data) {
                $this->_deleteSingleData($data, $dataName);
            }
        }
    }

    /**
     * Delete single data.
     *
     * @param unknown_type $data     TODO
     * @param unknown_type $dataName TODO
     *
     * @return void
     */
    private function _deleteSingleData($data, $dataName)
    {
        $dbtable = new $data['dbtable']();
        if ($dbtable instanceof \Zend_Db_Table_Abstract) {
            $tableInfo = $dbtable->info();
            $pk = $tableInfo['primary'];
            if (\count($pk) > 0) {
                if (array_key_exists($dataName, $this->_insertedIds)) {
                    $where = $dbtable->getAdapter()->quoteInto(
                        "{$pk[1]} =?",
                        $this->_insertedIds[$dataName]
                    );
                    $dbtable->delete($where);
                    unset($this->_insertedIds[$dataName]);
                }
            }
            $dbtable->getAdapter()->closeConnection();
        } else {
            throw new \Exception(
                "{$data['dbtable']} is not a child class of "
                . "Zend_Db_Table_Abstract"
            );
        }
    }
    /**
     * Insert test data in the test data file into database.
     *
     * @return void
     */
    protected function insertTestData() 
    {
        $config = $this->_readTestDataFile();
        if ($config) {
            foreach ($config->toArray() as $dataName => $data) {
                $id = $this->_insertSingleData($data, $dataName);
            }
        }
    }
    
    /**
     * _insertSingleData 
     * 
     * @param mixed  $data     data to insert into databases.
     * @param string $dataName the name of data. in ini it is the name of a
     *                         section
     *
     * @access private
     *
     * @return an hash array, the key is the name of data
     *         and the value is the id of the data.
     */
    private function _insertSingleData($data, $dataName)
    {
        $dbtable = new $data['dbtable']();
        if ($dbtable instanceof \Zend_Db_Table_Abstract) {
            $d = $this->_normalizeData($data);
            if (\count($d) == 0) {
                break;
            }
            try {
                $this->_insertedIds[$dataName] = $dbtable->insert($d);
                $dbtable->getAdapter()->closeConnection();
                return $this->_insertedIds;
            } catch(\Exception $e) {
                // Zend_Debug::dump($e);
                echo "---------------------\n";
                echo "**message: \n{$e->getMessage()} \n";
                echo "**tracing: \n{$e->getTraceAsString()} \n";
                echo "  \t the dbtable is: {$data['dbtable']}\n";
            }
        } else {
            throw new \Exception(
                "{$data['dbtable']} is not a child class of "
                . "Zend_Db_Table_Abstract"
            );
        }
    }

    /**
     * insert a data in the data file into the data base.
     * The data is indicated by the name.
     * If dataname is not array, it will be used as the key
     * of the test data.
     * If dataname is an array, all elements in it will be treated
     * as key of test data. And all of these test data will be inserted
     * into the database.
     *
     * @param string|array $dataname TODO
     *
     * @return unknown_type
     */
    protected function _insert($dataname)
    {
        $config = $this->_readTestDataFile();
        if ($config) {
            $configArray = $config->toArray();
            if (\is_array($dataname)) {
                $ids = array();
                foreach ($dataname as $dn) {
                    $ids[] = $this->_insertSingleData($configArray[$dn], $dn);
                }
                return $ids;    
            } else {
                return $this->_insertSingleData(
                    $configArray[$dataname], $dataname
                );
            }
        }
    }

    /**
     * delete the data in the data file from database.
     * The data is indicated by the name.
     * If dataname is not array, it will be used as the key
     * of the test data.
     * If dataname is an array, all elements in it will be treated
     * as key of test data. And all of these test data will be removed
     * from the database.
     *
     * @param string|array $dataname TODO
     *
     * @return void
     */
    protected function _delete($dataname)
    {
        $config = $this->_readTestDataFile();
        if ($config) {
            $configArray = $config->toArray();
            if (\is_array($dataname)) {
                foreach ($dataname as $dn) {
                    $this->_deleteSingleData($configArray[$dn], $dn);
                }    
            } else {
                $this->_deleteSingleData($configArray[$dataname], $dataname);
            }
        }
    }


    /**
     * read the test data file.
     *
     * @return Zend_Config_Ini 
     */
    private function _readTestDataFile()
    {
        $fileName = $this->getTestDataFile();
        if (\file_exists($fileName)) {
            return new \Zend_Config_Ini($fileName);
        } else {
            throw new \Exception("test data not found");
        }
    }
        /**
     * in the config file null is a string, it should be changed into php null
     * before send it to db table.
     *
     * @param unknown_type $data TODO
     *
     * @return unknown_type
     */
    private function _normalizeData($data)
    {
        foreach ($data['data'] as $k => $v) {
            $v == "null"? $d[$k] = null : $d[$k] = $v;
        }
        return $d;
    }

}
