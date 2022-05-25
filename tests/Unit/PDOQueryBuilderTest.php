<?php

namespace Tests\Unit;

use App\Database\PDODatabaseConnection;
use App\Database\PDOQueryBuilder;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;

class PDOQueryBuilderTest extends TestCase
{
    private $queryBuilder;
    public function setUp(): void
    {
        $pdoConnection = new PDODatabaseConnection($this->getConfig());
        $this->queryBuilder = new PDOQueryBuilder($pdoConnection->connect());
        parent::setUp();
    }
    public function testItCanCreateData()
    {
        $result = $this->insertIntoDB();
        $this->assertIsInt($result);
        $this->assertGreaterThan(0, $result);
    }

    public function testItCanUpdateData()
    {
        $this->insertIntoDB();
        $result = $this->queryBuilder
            ->table('bugs')
            ->where('user', 'Mojtaba Ahmadi')
            ->where('email', 'Mojtaba@gmail.com')
            ->update(['email' => 'Ali@gmail.com', 'name' => 'Fisrt Tests of love']);
        $this->assertEquals(1, $result);
    }
    public function testItCanDeleteRecord(){

        $this->insertIntoDB();
        $this->insertIntoDB();
        $this->insertIntoDB();
        $this->insertIntoDB();
        $result = $this->queryBuilder
            ->table('bugs')
            ->where('user','Mojtaba')
            ->delete();
        $this->assertEquals(0,$result);
    }
    private function insertIntoDB()
    {
        $data = [
            'name' => 'fisrt Bug Report',
            'email' => 'Mojtaba@gmail.com',
            'link' => 'http://link.com',
            'user' => 'Mojtaba Ahmadi'
        ];
        $result = $this->queryBuilder->table('bugs')->create($data);
        return $result;
    }

    private function getConfig()
    {
        return Config::get('database', 'pdo_testing');
    }
    public function tearDown():void
    {
        $this->queryBuilder->trancateAllTable();
        parent::tearDown();
    }
}
