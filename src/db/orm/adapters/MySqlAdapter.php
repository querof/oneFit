<?php

namespace src\db\orm\Adapters;

use src\db\Connection;
use src\db\orm\CrudBase;
use src\db\orm\Field;
use src\db\orm\Query;
use Symfony\Component\HttpFoundation\Request;


/*
 * Adapter Class for crud; implementations; it's builded and tested for postgresql.
 */

class MySqlAdapter implements CrudBase
{

  /*
   * \PDO content the connection object.
   */

    private $cnn;


    public function __construct()
    {
        $this->cnn = Connection::get()->connect();
    }


    /**
     * Method that create an new record in the table.
     *
     *
     * @param Array $fields. Array with the name of the fields.
     * @param Object $obj. Object with the values of the dml.
     */

    public function insert($fields, $obj)
    {
        $sql = 'INSERT INTO '.$obj->getTableName().' ('.implode(',', array_keys($fields)).') VALUES(:'.implode(',:', array_keys($fields)).')';

        $stmt = $this->cnn->prepare($sql);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(':'.$key, $obj->$key->getValue());
        }

        $stmt->execute();

        return  $this->cnn->lastInsertId();
    }


    /**
     * Method that update object data.
     *
     * @param Array $fields. Array with the name of the fields.
     * @param Object $obj. Object with the values of the dml.
     */

    public function update($fields, $obj)
    {
        $sql = 'UPDATE '.$obj->getTableName();
        $cols = ' SET ';

        foreach ($fields as $key => $value) {
            $cols .= ($cols != ' SET ')?','.$key.' = :'.$key:$key.' = :'.$key;
        }

        $sql .= $cols.' WHERE id = :id';

        $stmt = $this->cnn->prepare($sql);

        foreach ($fields as $key => $value) {
            $stmt->bindValue(':'.$key, $obj->$key->getValue());
        }

        $stmt->bindValue(':id', $obj->id->getValue());

        $stmt->execute();

        return $obj->id->getValue();
    }


    /**
     * Method that delete the data asocied to the object instanciated.
     *
     * @param  Integer $id. Pk of the record.
     * @param  String $tableName. Name of the table.
     */

    public function delete($id, $tableName)
    {
        $sql = 'DELETE FROM '.$tableName.' WHERE id = :id';

        $stmt = $this->cnn->prepare($sql);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * Method that returns an hidratated object with the result of a query filter by the table PK.
     *
     * @param  Integer PK of the table.
     * @param  String $tableName. Name of the table.
     * @param Array $fields. Array with the name of the fields.
     *
     * @return Array Object or empty array
     */

    public function findByPk($id, $tableName, $fields)
    {
        $stmt = $this->cnn->prepare('SELECT * FROM '.$tableName.'  WHERE id = :id');

        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $this->hidratate($stmt, $fields);
    }

    /**
     * Method that returns an hidratated object with the result of a query of all data of the table.
     *
     * @param  String $tableName. Name of the table.
     * @param Array $fields. Array with the name of the fields.    *
     *
     * @return Array Object or empty array
     */

    public function findAll($tableName, $fields, Request $request)
    {
        $sql = 'SELECT * FROM '.$tableName.($request->get('page')!==null?' LIMIT '.($request->get('page')>1?($request->get('page')-1)*10:$request->get('page')).', 10':'');

        $stmt = $this->cnn->prepare($sql);

        $stmt->execute();

        return $this->hidratate($stmt, $fields);
    }

    /**
     * Method that returns an hidratated object with the result of a query filter by
     * parameters send in $params.
     *
     * @param  Array $param thats content field and value to filter the data from the table.
     *
     * @return Array Object or empty array
     */

    public function findBy($tableObj, $params = [])
    {
        $sqlObj = new Query($params);
        $stmt = $this->cnn->prepare($sqlObj->select()->build());

        foreach ($params as $table => $fields) {
            foreach ($fields as $k => $field) {
                if (array_key_exists('value', $field)) {
                    $stmt->bindValue(':'.$table.$k, $field['value']);
                }
            }
        }

        $stmt->execute();
        return $this->hidratate($stmt);
    }


    /**
     * Method that returns an hidratated object and child relationships
     *
     * @param  Object $stmt thats content PDO sql sencence prepared.
     *
     * @return Object $this.
     */

    public function hidratate($stmt, $fields=[])
    {
        $result = array();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        return $result;
    }
}
