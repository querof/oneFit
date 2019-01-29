<?php

namespace src\db\orm\model;

use src\db\orm\TableBase;
use src\db\orm\Field;
use src\db\orm\EntityMethods;

/*
 * Excercises table entity class
 */

class Excercises extends TableBase
{

  /*
   * String Property that contains the name of the table related with the class.
   */
    private $tableName = 'excercises';


    /*
     * Array Property that contains the names of the fields in the class.
     */

    private $fields;



    /*
     * Array Property that contains the fields datatipes of the the class.
     */

    private $dataTypes = ['id' => 'int','name' => 'string', 'description' => 'string'];


    /*
     * Array Property that contains the names of the tables with FK relations in this table.
     */

    private $fathers = array();


    /*
     * Array Property that contains the names of the tables where this table is a FK.
     */

    private $childs = array('workout_days_excercises');


    /*
     * Integer Property that contains the PK of the table.
     */

    public $id;


    /*
     * String Property that contains the name of the Excercises.
     */

    public $name;

    /*
     * String Property that contains the long description of the Excersice.
     */

    public $description;


    use EntityMethods;
}
