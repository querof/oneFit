<?php

namespace src\db\orm;

/*
 * Trait thats contains the entity base methods.
 */

trait EntityMethods
{


  /**
   * Returns the name of the table associed with the Entity class.
   *
   * @return String.
   */

    public function getTableName()
    {
        return $this->tableName;
    }


    /**
     * Returns the fields names of the table associed with the Entity class.
     *
     * @return String array.
     */

    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Returns the fields names of the table associed with the Entity class.
     *
     * @return String array.
     */

    public function getFieldsSave()
    {
        $fields = $this->getFields();
        array_splice($fields, 0, 1);
        return $fields;
    }


    /**
     * Asings the name of the fields of table associed with the Entity class.
     *
     */

    public function setFields()
    {
        $properties = get_object_vars($this);
        $this->fields =  array_splice($properties, 5);
    }


    /**
     * Returns the name of the tables with fk relation in the table.
     *
     * @return String array.
     */

    public function getFathers()
    {
        return $this->fathers;
    }


    /**
     * Returns the name of the tables where this table is fk.
     *
     * @return String array.
     */

    public function getChilds()
    {
        return $this->childs;
    }


    /**
     * Returns the dataypes of the fields.
     *
     * @return String array.
     */

    public function getDataTypes()
    {
        return $this->dataTypes;
    }
}
