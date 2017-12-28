<?php
namespace App\Core;

/**
* 
*/
class Database
{
    private $host;
    private $dbname;
    private $user;
    private $secret;

    private $connection;

    public function __construct(Array $config)
    {
        $this->connection = new \PDO('mysql:host='.$config['database']['host'].';dbname='.$config['database']['database'], $config['database']['user'], $config['database']['secret']);
    }
    
}
