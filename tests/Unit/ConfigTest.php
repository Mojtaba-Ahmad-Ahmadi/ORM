<?php

namespace Tests\Unit;

use App\Exceptions\ConfigFileNotFoundException;
use App\Helpers\Config;

use PHPUnit\Framework\TestCase;

require('src/Helpers/Config.php');
require('src/Exceptions/ConfigFileNotFoundException.php');
class ConfigTest extends TestCase
{
    public function testGetFileContentsReturnArray()
    {
        $config = Config::getFileContents("database");
        $this->assertIsArray($config);
    }
    public function testThrowsExceptionIfFileNotFound()
    {
        $this->expectException(ConfigFileNotFoundException::class);
        $config = Config::getFileContents('dummmy');
    }
    public function testGetMethodReturnsValidData()
    {
        $config = Config::get('database', 'pdo');
        $expectedData = [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'ormdb',
            'db_user' => 'root',
            'db_password' => '123456'
        ];
        $this->assertEquals($config, $expectedData);
    }
}
