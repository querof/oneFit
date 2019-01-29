<?php

namespace src\db\orm\model;

use src\db\orm\TableBase;
use src\db\orm\Field;
use src\db\orm\EntityMethods;

/*
 * User table entity class
 */

class User extends TableBase
{

  /*
   * String Property that contains the name of the table related with the class.
   */
    private $tableName = 'user';


    /*
     * Array Property that contains the names of the fields in the class.
     */

    private $fields;


    /*
     * Array Property that contains the fields datatipes of the the class.
     */

    private $dataTypes = ['id' => 'int','name' => 'string','lastname' => 'string','email' => 'string','size' => 'float','weight' => 'float','password' => 'string','confirmed' => 'bool'];



    /*
     * Array Property that contains the names of the tables with FK relations in this table.
     */

    private $fathers = array();


    /*
     * Array Property that contains an array with names of the tables where this table is a FK.
     */

    private $childs = array('user_plan');


    /*
     * Integer Property that contains the PK of the table.
     */

    public $id;


    /*
     * String Property that contains the value of the user name, used in the AUTH.
     */

    public $name;


    /*
     * String Property that contains the value of the Lasrt name of the user.
     */

    public $lastname;

    /*
     * String Property that contains the value of the email of the user.
     */

    public $email;

    /*
     * String Property that contains the value of the password hash generated.
     */

    public $password;


    /*
     * Float Property that contains the value of the size of the user
     */

    public $size;

    /*
     * Float Property that contains the value of the size of the weight of the user.
     */

    public $weight;

    /*
     * Booll Property that contains the value of the the user confirmation
     */

    public $confirmed;

    use EntityMethods;
}
