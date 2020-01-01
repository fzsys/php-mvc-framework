<?php

namespace core\admin\models;

use core\base\controllers\Singleton;
use core\base\models\BaseModel;

class Model extends BaseModel
{
    use Singleton;

    public function showForeignKeys($table, $key = false)
    {

        $db = DB_NAME;

        if ($key) {
            $where = "AND COLUMN_NAME = '$key' LIMIT 1";
        }
        $query = "SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = '$db' AND TABLE_NAME = '$table' AND
                CONSTRAINT_NAME <> 'PRIMARY' AND REFERENCED_TABLE_NAME IS NOT NULL $where";

        return $this->query($query);
    }
}