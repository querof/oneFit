<?php

namespace src\db\orm\model;

use src\db\orm\TableBase;
use src\db\orm\Field;
use src\db\orm\EntityMethods;

/*
 * UserPlan table entity class
 */

class UserPlan extends TableBase
{

  /*
   * String Property that contains the name of the table related with the class.
   */
    private $tableName = 'user_plan';


    /*
     * Array Property that contains the names of the fields in the class.
     */

    private $fields;



    /*
     * Array Property that contains the fields datatipes of the the class.
     */

    private $dataTypes = ['id' => 'int','userid' => 'int', 'planid' => 'int'];


    /*
     * Array Property that contains the names of the tables with FK relations in this table.
     */

    private $fathers = array('user','plan');


    /*
     * Array Property that contains the names of the tables where this table is a FK.
     */

    private $childs = array();


    /*
     * Integer Property that contains the PK of the table.
     */

    public $id;


    /*
     * Integer Property that contains the value of the FK in the Plan table. User.
     */

    public $userid;

    /*
     * Integer Property that contains the value of the FK in the Plan table. Plan.
     */

    public $planid;


    use EntityMethods;
}
