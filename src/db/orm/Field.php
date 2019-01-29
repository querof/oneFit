<?php
namespace src\db\orm;

/*
 * Base Class for field objects.
 */

class Field
{

  /*
   * Property that contains value of the field.
   */

    private $value;

    /*
     * Property that contains datatype of the field.
     */

    private $dataType;

    /*
     * Property that contains the field vlidator.
     */

    private $validator;


    /**
     * Returns the fields value.
     *
     * @return var.
     */

    public function __construct($datatype)
    {
        $this->dataType = $datatype;
    }


    /**
     * Gets the fields value.
     *
     * @param var.
     */

    public function getValue()
    {
        return $this->value;
    }


    /**
     * Set the fields value.
     *
     * @param var.
     */

    public function setValue($value)
    {
        $this->value = $value;
    }


    /**
     * Gets the fields datatype.
     *
     * @param var.
     */

    public function getDataType()
    {
        return $this->dataType;
    }
}
