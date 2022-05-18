<?php

namespace Tests\Unit;

use App\Database\PDODatabaseConnection;
// require('./src/Database/PDODatabaseConnection.php');
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;
class PDoDatabaseConnectionTest extends TestCase
{
    public function testPDODatabaseConnectionImplementsDatabaseConnectionInterface()
    {
        $configs = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($configs);
        $this->assertInstanceOf(DatabaseConnectionInterface::class, $pdoConnection);
    }
    private function getConfig()
    {
        $config = Config::get('database', 'pdo');
        return $config;
    }
}
