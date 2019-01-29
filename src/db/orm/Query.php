<?php
namespace src\db\orm;

use src\db\orm\model\EntityFactory;

/*
 * Base Class for Query objects.
 */

class Query
{
    /*
     * Property that contains the tables+joins of the query.
     */

    private $tables;

    /*
     * Property that contains fields to show in the query result.
     */

    private $fields = '';


    /*
     * Property that contains the where of the query.
     */

    private $where = '';

    /*
     * Property that contains the where group by of the query.
     */

    private $groupBy = '';

    /*
     * Property that contains the where order by of the query.
     */

    private $orderBy = '';

    /*
     * Property that contains the array with the constructions instructions of the query.
     */

    private $params = [];



    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * Function that calls the functions that sets the query elements.
     *
     * @param var.
     */

    public function select()
    {
        foreach ($this->params as $key => $value) {
            $this->setFieldsInfo($key, $value);
            $this->setEntityObj($key, $value);
        }
        $this->fields = $this->fields??'*';
        $this->tables = $this->tables??implode(',', array_keys($this->params));

        return $this;
    }


    /**
     * Returns sql sentence.
     *
     * @param var.
     */

    public function build()
    {
        return 'select '.$this->fields.' from '.$this->tables.$this->where.$this->groupBy.$this->orderBy;
    }

    /**
     * Gets the fields information.
     *
     * @param String $table. Name of the table.
     * @param Array $fields. Array with fields of the table.
     */

    private function setFieldsInfo($table, $fields)
    {
        foreach ($fields as $key => $value) {
            $field = $table.'.'.$key.' '.$table.'_'.$key;

            if (array_key_exists('function', $fields[$key])) {
                $field = $fields[$key]['function'].'('.$table.'.'.$key.') '.$fields[$key]['function'].'_'.$table.'_'.$key;
            }

            $this->fields .= ($this->fields<>''?', ':' ').$field;

            if (array_key_exists('value', $fields[$key])) {
                $this->where .= $this->where == ''?' where '.$table.'.'.$key.' = :'.$table.$key :' and '.$table.'.'.$key.' = :'.$table.$key;
            }
            if (array_key_exists('order', $fields[$key])) {
                $this->orderBy .= $this->orderBy <> ''?', '.$table.'.'.$key:' order by '.$table.'.'.$key.' '.$fields[$key]['order'];
            }
            if (array_key_exists('group', $fields[$key])) {
                $this->groupBy .= $this->groupBy <> ''?', '.$table.'.'.$key:' group by '.$table.'.'.$key;
            }
        }
    }

    /**
     * Sets the entity instances. And set the jins including INNER/LEFT/RIGHT joins
     *
     * @param String $table. Name of the table.
     * @param Array $fields. Array with fields of the table.
     */

    private function setEntityObj($tableName, $fields)
    {
        $obj = new EntityFactory();

        $relationObj= $obj->create($tableName);
        foreach ($relationObj->getFathers() as $key => $value) {
            if (array_key_exists($value, $this->params)) {
                if (strpos($this->tables, ' '.$tableName.' ') === false) {
                    $this->tables .= $this->tables==''?' '.$tableName.' ':' INNER JOIN '.$tableName.' ';
                }
                $this->setJoins($tableName, $value, $fields);
            }
        }
    }

    /**
     * Sets the Joins.
     *
     * @param String $table. Name of the table.
     * @param String $value. table father cotained in the query.
     * @param Array $fields. Array with fields of the table.
     */

    private function setJoins($tableName, $value, $fields)
    {
        $fieldPrefix = str_replace("_", "", $value);


        if (array_key_exists($fieldPrefix.'id', $fields)) {
            $clause = array_key_exists('outer', $fields[$fieldPrefix.'id'])?$fields[$fieldPrefix.'id']['outer']:' INNER';
        }

        $this->tables .=  $clause.' JOIN '.$value.' on '.$value.'.id = '.$tableName.'.'.$fieldPrefix.'id ';
    }
}
