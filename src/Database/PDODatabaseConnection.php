<?php

namespace App\Database;

use PDOException;
use PDO;
use App\Contracts\DatabaseConnectionInterface;
use App\Exceptions\ConfigNotValidException;
use App\Exceptions\DatabaseConnectionException;

class PDODatabaseConnection implements DatabaseConnectionInterface
{
    protected $connection;
    protected $config;
    const REQUEST_CONFIG_KEYS = [
        'driver',
        'host',
        'database',
        'db_user',
        'db_password'
    ];

    public function __construct(array $config)
    {
        if (!$this->isConfigValid($config)) {
            throw new ConfigNotValidException();
        }
        $this->config = $config;
    }
    public function connect()
    {
        
        $dsn = $this->generateDsn($this->config);
        try {
            $this->connection = new PDO(...$dsn);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new DatabaseConnectionException("BBBBBBBBBBBBBBBBBBBBBBB");
        }
        return $this;
    }

    private function generateDsn(array $config)
    {
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        return [$dsn, $config['db_user'], $config['db_password']];
    }
    public function getConnection()
    {
        return $this->connection;
    }
    private function isConfigValid(array $config)
    {
        $matches = array_intersect(self::REQUEST_CONFIG_KEYS, array_keys($config));
        return count($matches) === count(self::REQUEST_CONFIG_KEYS);
    }
}