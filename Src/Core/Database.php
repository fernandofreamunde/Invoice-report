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

    public function __construct( Array $config)
    {
        var_dump($config);die('YO!!');
    }

    /*public function __construct()
    {
        $parsed = yaml_parse_file('Src/Config/config.yaml');

        $this->host = $parsed['database']['host'];
        $this->dbname = $parsed['database']['database'];
        $this->user = $parsed['database']['user'];
        $this->secret = $parsed['database']['secret'];
    }

    public function connect()
    {
        $this->connection = new \PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->secret);
    }*/
}
