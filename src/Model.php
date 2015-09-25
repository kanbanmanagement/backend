<?php

namespace Slimvc;

/**
* Model class
*/
class Model
{
    private $queryInstance = null;

    public function __construct($queryInstance)
    {
        $this->queryInstance = $queryInstance;
    }

    public function get($column = '*', array $where = null)
    {
        $table = $this->queryInstance;
        if (!empty($where) && is_array($where)) {
            $data = $table->read($column)
                       ->where($where)
                       ->get([
                        'all' => true,
                        'fetch' => 'assoc'
                       ]);
        } else {
            $data = $table->read($column)
                       ->get([
                        'all' => true,
                        'fetch' => 'assoc'
                       ]);
        }

        return $data;
    }

    public function set($fields)
    {
        if (!empty($fields) && is_array($fields)) {
            return $this->queryInstance
                        ->create($fields);
        }

        return false;
    }

    public function update(array $fields, array $where)
    {
        if (!empty($where) && is_array($where) && !empty($fields) && is_array($fields)) {
            return $this->queryInstance
                        ->update($fields)
                        ->where($where)
                        ->exec();
        }

        return false;
    }

    public function delete(array $where = null)
    {
        if (!empty($where) && is_array($where)) {
            return $this->queryInstance
                        ->delete()
                        ->where($where)
                        ->exec();
        } else {
            return $this->queryInstance
                        ->delete()
                        ->exec();
        }
    }
}
