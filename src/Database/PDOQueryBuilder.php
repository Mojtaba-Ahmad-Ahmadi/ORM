<?php

namespace App\Database;

use App\Contracts\DatabaseConnection;
use App\Contracts\DatabaseConnectionInterface;
use PDO;

class PDOQueryBuilder
{
    protected $table;
    protected $connection;
    protected $conditions;
    protected $value;

    public function  __construct(DatabaseConnectionInterface $connection)
    {
        $this->connection = $connection->getConnection();
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function create(array $data)
    {
        $placeholder = [];
        foreach ($data as $key => $value) {
            $placeholder[] = '?';
        }
        $filds = implode(',', array_keys($data));
        $placeholder = implode(',', $placeholder);
        $sql = "INSERT INTO {$this->table} ({$filds}) VALUES ({$placeholder})";
        $query = $this->connection->prepare($sql);
        $query->execute(array_values($data));
        return (int)$this->connection->lastInsertID();
    }

    public function where(string $columns, string $value)
    {
        $this->conditions[] = "{$columns}=? ";
        $this->value[] = $value;
        return $this;
    }
    public function update(array $data)
    {
        $filds  = [];
        foreach ($data as $key => $value) {
            $filds[] = "{$key} ='{$value}'";
        }
        $filds = implode(',', $filds);
        $conditions = implode(' and ', $this->conditions);
        $sql = "UPDATE {$this->table} SET {$filds} WHERE {$conditions}";
        $query = $this->connection->prepare($sql);
        $query->execute($this->value);
        return $query->rowCount();
    }
    public function delete()
    {
        $conditions = implode(' and ', $this->conditions);
        $sql = "DELETE FROM {$this->table} WHERE {$conditions}";
        $query = $this->connection->prepare($sql);
        $query->execute($this->value);
        return $query->rowCount();
    }
    public function trancateAllTable()
    {
        $query = $this->connection->prepare("SHOW TABLES");
        $query->execute();
        $fetchdata = $query->fetchAll(PDO::FETCH_COLUMN);
        foreach ($fetchdata as $table) {
            $this->connection->prepare("TRUNCATE TABLE {$table}")->execute();
        }
    }
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }
    public function rollback()
    {
        $this->connection->rollback();
    }
}
