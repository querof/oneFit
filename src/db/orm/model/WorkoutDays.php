<?php

namespace src\db\orm\model;

use src\db\orm\TableBase;
use src\db\orm\Field;
use src\db\orm\EntityMethods;

/*
 * WorkoutDays table entity class
 */

class WorkoutDays extends TableBase
{

  /*
   * String Property that contains the name of the table related with the class.
   */
    private $tableName = 'workout_days';


    /*
     * Array Property that contains the names of the fields in the class.
     */

    private $fields;



    /*
     * Array Property that contains the fields datatipes of the the class.
     */

    private $dataTypes = ['id' => 'int','name' => 'string', 'description' => 'string','planid' => 'int','weekday'=>'string'];


    /*
     * Array Property that contains the names of the tables with FK relations in this table.
     */

    private $fathers = array('plan');


    /*
     * Array Property that contains the names of the tables where this table is a FK.
     */

    private $childs = array('workout_days_excercises');


    /*
     * Integer Property that contains the PK of the table.
     */

    public $id;


    /*
     * String Property that contains the name of the WorkoutDays.
     */

    public $name;

    /*
     * String Property that contains the long description of the WorkoutDays.
     */

    public $description;

    /*
     * Integer Property that contains the value of the FK in the Plan table.Plan
     */

    public $planid;

    /*
     * String Property that contains the value of the week of the day.
     */

    public $weekday;

    use EntityMethods;
}
