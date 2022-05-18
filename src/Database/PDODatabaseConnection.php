<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
// require('./src/Contracts/DatabaseConnectionInterface.php');

class PDoDatabaseConnection implements DatabaseConnectionInterface
{

    public function connect()
    {
        echo "kj";

    }
    public function getConnection()
    {
        echo "kj";
    }
}
