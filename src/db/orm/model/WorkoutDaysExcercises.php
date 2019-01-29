<?php

namespace src\db\orm\model;

use src\db\orm\TableBase;
use src\db\orm\Field;
use src\db\orm\EntityMethods;

/*
 * WorkoutDaysExcercises table entity class
 */

class WorkoutDaysExcercises extends TableBase
{

  /*
   * String Property that contains the name of the table related with the class.
   */
    private $tableName = 'workout_days_excercises';


    /*
     * Array Property that contains the names of the fields in the class.
     */

    private $fields;



    /*
     * Array Property that contains the fields datatipes of the the class.
     */

    private $dataTypes = ['id' => 'int','workoutdaysid' => 'int', 'excercisesid' => 'int','repetitions'=>'int'];


    /*
     * Array Property that contains the names of the tables with FK relations in this table.
     */

    private $fathers = array('workout_days','excercises');


    /*
     * Array Property that contains the names of the tables where this table is a FK.
     */

    private $childs = array();


    /*
     * Integer Property that contains the PK of the table.
     */

    public $id;


    /*
     * Integer Property that contains the value of the FK in the Plan table. WorkoutDays.
     */

    public $workoutdaysid;

    /*
     * Integer Property that contains the value of the FK in the Plan table. Excercises.
     */

    public $excercisesid;

    /*
     * Integer Property that contains the value of the number of repetitions of the excercise.
     */

    public $repetitions;


    use EntityMethods;
}
