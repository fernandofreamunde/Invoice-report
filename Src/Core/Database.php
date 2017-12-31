<?php
namespace App\Core;

use App\Core\Query;
use App\Core\Configuration;
use \PDO as Pdo;

/**
* 
*/
class Database
{
    protected $connection;

    public function __construct(Configuration $configuration)
    {
        $config = $configuration->get('database');
        $this->connection = new Pdo('mysql:host='.$config['host'].';dbname='.$config['database'], $config['user'], $config['secret']);
    }

    private function rowToObject($row, $entity)
    {
        $reflection = new \ReflectionClass(get_class($entity));
        $entity = $reflection->newInstanceArgs([]);

        foreach ($row as $column => $value) {
            $reflectionProp = $reflection->getProperty($column);
            $reflectionProp->setAccessible(true);
            
            if (class_exists($reflectionProp->getValue($entity))) {


                $relationReflection = new \ReflectionClass($reflectionProp->getValue($entity));
                
                $relationReflectionProp = $relationReflection->getProperty('id');
                $relationReflectionProp->setAccessible(true);

                //because entities should not have paramters we pass an enpty array
                $obj = $relationReflection->newInstanceArgs([]);

                $relationReflectionProp->setValue($obj, $value);
                $value = $obj;

            }

            $reflectionProp->setValue($entity, $value);
        }

        return $entity;
    }

    protected function toArrayOfObjects($rows, $entity) {

        $objects = [];
        foreach ($rows as $row) {
            $objects[] = $this->rowToObject($row, $entity);
        }
        return $objects;
    }

    public function runQuery(Query $query)
    {
        $stmt = $this->connection->prepare($query->getQuery());
        $stmt->execute($query->getValues());

        $result = $stmt->fetchAll(Pdo::FETCH_ASSOC);

        return $this->toArrayOfObjects($result, $query->getEntity());
    }

}
