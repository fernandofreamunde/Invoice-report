<?php 

namespace App\Core;

/**
* 
*/
class Query
{
    const EQUALS      = '=';
    const NOT_EQUALS  = '<>';
    const BIGGER_THAN = '>';
    const LESSER_THAN = '<';

    private $values   = [];
    private $counters = [];
    private $query;


    function __construct($entity)
    {
        $this->entity = $entity;

        $this->query = 'SELECT * FROM ' . $entity::TABLE . ' ';
    }

    private function setValues($column, $value)
    {
        if (isset($this->values[':' .$column]))
        {
            if (empty($this->counters)) {
                $this->counters[':' .$column][] = $this->values[':' . $column];
            }
            // this is just to set the iterators could be any value actually 
            // or just a counter but for now this does the trick
            $this->counters[':' .$column][] = $value;
            $iterator = count($this->counters[':' .$column]) -1;

            $this->values[':' . $column . $iterator] = $value;
            return count($this->counters[':' .$column]) -1;
        }
        
        $this->values[':' . $column] = $value;
        return 0;
    }

    public function filterBy($column, $value, $criteria = self::EQUALS)
    {
        $counter = $this->setValues($column, $value);

        if ($counter == 0) {
            $this->query .= 'WHERE ' . $column . ' ' . $criteria . ' :' . $column . ' ';
        }
        else
        {
            $this->query .= 'WHERE ' . $column . ' ' . $criteria . ' :' . $column . $counter . ' ';
        }
    }

    public function and()
    {
        $this->query .= 'AND ';
    }

    public function or()
    {
        $this->query .= 'OR ';
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getTable()
    {
        return $this->getEntity()::TABLE;
    }

    public function getEntity()
    {
        return $this->entity;
    }
}