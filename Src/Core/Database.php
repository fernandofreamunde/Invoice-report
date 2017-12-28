<?php
namespace App\Core;
use App\Core\Configuration;
use \PDO as Pdo;

/**
* 
*/
class Database
{
    protected $connection;
    const WHITELISTED = [
        'invoices',
        'invoice_items',
    ];

    public function __construct(Configuration $configuration)
    {
        $config = $configuration->get('database');
        $this->connection = new Pdo('mysql:host='.$config['host'].';dbname='.$config['database'], $config['user'], $config['secret']);
    }

    public function getAllFromTable($table)
    {
        
        $table = in_array($table, self::WHITELISTED) ? $table: false;

        if (!$table) {
            die('ERROR');
        }

        $stmt = $this->connection->prepare("SELECT * FROM ".$table);
        $stmt->execute();

        return $stmt->fetchAll(Pdo::FETCH_ASSOC);
    }
}
