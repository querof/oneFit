<?php

namespace src\db\orm;

use Symfony\Component\HttpFoundation\Request;

/*
 * Interface thats describe the main Crud Methods
 */

interface CrudBase
{
    public function insert($fields, $obj);

    public function update($fields, $obj);

    public function delete($id, $tableName);

    public function findByPk($id, $tableName, $fields);

    public function findAll($tableName, $fields, Request $request);

    public function findBy($tableName, $params = []);

    public function hidratate($stmt, $fields);
}
