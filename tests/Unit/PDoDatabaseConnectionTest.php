<?php

namespace Tests\Unit;

use PDO;
use App\Database\PDODatabaseConnection;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;
use App\Contracts\DatabaseConnectionInterface;
use App\Exceptions\ConfigNotValidException;
use App\Exceptions\DatabaseConnectionException;
use PDOStatement;

class PDODatabaseConnectionTest extends TestCase
{
    public function testPDODatabaseConnectionImplementsDatabaseConnectionInterface()
    {
        $configs = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($configs);
        $this->assertInstanceOf(DatabaseConnectionInterface::class, $pdoConnection);
    }



    public function testConnectMethodShouldReturnValidInstance()
    {
        $config = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($config);
        $pdoHandalar = $pdoConnection->connect();
        $this->assertInstanceOf(PDODatabaseConnection::class, $pdoHandalar);
        return $pdoHandalar;
    }
    /**
     * @depends testConnectMethodShouldReturnValidInstance
     */
    public function testConnectMethodShouldBeConnectToDatabase($pdoHandalar)
    {
        $this->assertInstanceOf(PDO::class, $pdoHandalar->getConnection());
    }  

    public function testItThrowsExceptionIfConfigIsInvalid()
    {
        $this->expectException(DatabaseConnectionException::class);
        $config = $this->getConfig();
        $config['database']='diumy!';
        $pdoConnection = new PDODatabaseConnection($config);
        $pdoConnection->connect();
    }
    public function testRecivedConfigHaveRequiredkey()
    {
        $this->expectException(ConfigNotValidException::class);
        $config = $this->getConfig();
        unset($config['db_user']);
        $pdoConnection = new PDODatabaseConnection($config);
        $pdoConnection->connect();
    }

    private function getConfig()
    {
        $config = Config::get('database', 'pdo_testing');
        return $config;
    }
}
