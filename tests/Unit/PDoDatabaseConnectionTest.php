<?php

namespace Tests\Unit;

use App\Database\PDODatabaseConnection;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;
use App\Contracts\DatabaseConnectionInterface;


class PDODatabaseConnectionTest extends TestCase
{
    public function testPDODatabaseConnectionImplementsDatabaseConnectionInterface()
    {
        $configs = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($configs);
        $this->assertInstanceOf(DatabaseConnectionInterface::class, $pdoConnection);
    }
    public function testConnectMethodShouldBeConnectToDatabase()
    {
        $config = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($config);
        $pdoConnection->connect();
        $this->assertInstanceOf(PDO::class,$pdoConnection->getConnection());

    }
    private function getConfig()
    {
        $config = Config::get('database', 'pdo_testing');
        return ($config);
    }
}
