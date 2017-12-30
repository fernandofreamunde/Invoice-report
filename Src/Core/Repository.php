<?php 

namespace App\Core;

use App\Core\Query;
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

    public function getAll()
    {
        $query = new Query($this->entity);
        return $this->db->runQuery($query);
    }

}