<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;

class PDoDatabaseConnection implements DatabaseConnectionInterface
{
    protected $connection;
    public function connect()
    {
        echo "kj";
    }
    public function getConnection()
    {
        echo "kj";
    }
}
