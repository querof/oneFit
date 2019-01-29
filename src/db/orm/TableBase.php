<?php

namespace src\db\orm;

use src\db\orm\Field;
use src\db\orm\model\EntityFactory;
use src\db\orm\adapters\AdapterFactory;
use Symfony\Component\HttpFoundation\Request;

/*
 * Base Class for crud and  implementation of the system.
 */

class TableBase
{

  /*
   * Database object adapter.
   */

    private $dbObj;

    /*$cols
     * Array Property that contains an array with the data result from a query.
     */

    private $data = null;


    /*
     * Array Property that contains the objects of the records thats have a FK relationsship with the table.
     */

    private $fathersObj;


    /*
     * Array Property that contains the objects of the records thats  where the tabe has a FK relationsship with.
     */

    private $childsObj;


    public function __construct()
    {
        $adapter = new AdapterFactory();
        $this->dbObj = $adapter->create();

        $this->setFields();
        foreach ($this->getFields() as $key => $value) {
            $this->$key = new Field($this->getDataTypes()[$key]);
        }
    }


    /**
     * Method thats persist the information of the object in the DB; it makes a
     * choice if is an insertion or an update.
     *
     * @return Integer return the id of the fle inserted/count of files affected
     */

    public function save()
    {
        $fields = $this->getFieldsSave();

        if ($this->getData() === null) {
            $this->id->setValue($this->dbObj->insert($fields, $this));
        }
        $this->id->setValue($this->dbObj->update($fields, $this));

        $this->findByPk($this->id->getValue());

        $this->hidratate($this->getData())->getData();
        
        return $this->id->getValue();
    }

    /**
     * Method that returns the information of the names of father tables
     *
     * @return Array with the data.
     */

    public function getFathers()
    {
        return $this->fathers;
    }


    /**
     * Method that returns the information of the names of father tables
     *
     * @return Array with the data.
     */

    public function getChilds()
    {
        return $this->childs;
    }

    /**
     * Method that returns the information of the data of the resulted froma query.
     *
     * @return Array with the data.
     */

    public function getData()
    {
        return $this->data;
    }


    /**
     * Method that asign the information of the data of the resulted from a query.
     * to the data property.
     *
     * @param  Array with the data result of a query, can content null value.
     */

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }


    /**
     * Method that delete the data related to the object instanciated.
     *
     * @param  Integer count of records affected.
     */

    public function delete()
    {
        $rows = $this->dbObj->delete($this->id->getValue(), $this->getTableName());

        if ($rows == 1) {
            $this->setData(null)->id->setValue(null);
        }

        return $rows;
    }


    /**
     * Method that returns an hidratated object with the result of a query filter by the table PK.
     *
     * @param  Integer PK of the table.
     *
     * @return Array Object or empty array
     */

    public function findByPk($id)
    {
        $data = $this->dbObj->findByPk($id, $this->getTableName(), $this->getFields());

        return $this->hidratate($data)->getData();
    }


    /**
     * Method that returns an hidratated object with the result of a query of all data of the table.
     *
     *
     * @return Array Object or empty array
     */

    public function findAll(Request $request)
    {
        $data = $this->dbObj->findAll($this->getTableName(), $this->getFields(), $request);

        return $this->hidratate($data)->getData();
    }


    /**
     * Method that returns an hidratated object with the result of a query filter by
     * parameters send in $params.
     *
     * @param  Array $param thats content field and value to filter the data from the table.
     *
     * @return Array Object or empty array
     */

    public function findBy(array $params, array $relations = [])
    {
        $data = $this->dbObj->findBy($this, $params);

        return $this->setData($data)->getData();
    }


    /**
    * Method that returns an array with the Father related objects.
    *
    *
    * @return Array.
    */
    public function getFathersObj()
    {
        return $this->fathersObj;
    }


    /**
     * Method that returns an array with the child related object.
     *
     *
     * @return Array.
     */

    public function getChildsObj()
    {
        return $this->childsObj;
    }


    /**
     * Method that asign father relationships.
     */

    public function findFathers()
    {
        $this->fathersObj = array();
        foreach ($this->getFathers() as $key => $value) {
            $fact = new EntityFactory();
            $obj = $fact->create($value);
            $value = str_replace("_", "", $value).'id';
            $this->fathersObj[] = $obj->findByPk($this->$value->getValue());
        }
    }


    /**
     * Method that asign child relationships.
     */
//
    public function findChilds()
    {
        $this->childsObj = array();
        foreach ($this->getChilds() as $key => $value) {
            $fact = new EntityFactory();
            $obj = $fact->create($value);

            $this->childsObj[] = $obj->findBy(array(str_replace("_", "", $this->getTableName()).'id' => $this->id->getValue()));
        }
    }


    /**
     * Method that returns an hidratated object and child relationships
     *
     * @param  Object $stmt thats content PDO sql sencence prepared.
     *
     * @return Object $this.
     */

    private function hidratate($data)
    {
        foreach ($data as $key => $row) {
            foreach ($row as $key => $value) {
                $this->$key->setValue($value);
            }
        }

        $this->setData($data);
        $this->findFathers();

        return $this;
    }
}
