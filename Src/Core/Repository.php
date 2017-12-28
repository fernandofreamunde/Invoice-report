<?php 

namespace App\Core;
use App\Core\Database;

/**
* 
*/
class Repository 
{
    private $db;

    function __construct(Database $db)
    {
        $this->db = $db;
    }

    private function getTable()
    {
        return $this->getEntity()::TABLE;
    }

    private function getEntity()
    {
         return $this->entity;
    }

    private function rowToObject($row)
    {
        $entity = $this->getEntity();
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

            #$reflectionProp = $reflection->getProperty($column);
            $reflectionProp->setValue($entity, $value);
        }

        return $entity;
    }

    protected function toArrayOfObjects($rows) {

        $objects = [];
        foreach ($rows as $row) {
            $objects[] = $this->rowToObject($row);
        }
        return $objects;
    }

    public function getAll()
    {
        return $this->toArrayOfObjects($this->db->getAllFromTable($this->getTable()));
    }

    protected function query($query, $values = null)
    {

        $stmt = $db->prepare("SELECT * FROM table WHERE id=:id AND name=:name");
        $stmt->execute(array(':name' => $name, ':id' => $id));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "string";
        $this->getTable();
    }
}