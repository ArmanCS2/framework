<?php

namespace System\Database\DBConnection;

use PDO;
use PDOException;
use System\Config\Config;

class DataBase
{
    private $connection;
    private $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];

    function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . Config::get('database.DB_HOST') . ";dbname=" . Config::get('database.DB_NAME'), Config::get('database.DB_USERNAME') , Config::get('database.DB_PASSWORD'), $this->options);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function select($sql, $values = null)
    {
        try {
            $stmt = $this->connection->prepare($sql);
            if ($values == null) {
                $stmt->execute();
            } else {
                $stmt->execute($values);
            }
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insert($tableName, $fields, $values)
    {
        $sql = "INSERT INTO " . $tableName . "(" . implode(', ', $fields) . ",created_at) VALUES (:" . implode(', :', $fields) . ",NOW())";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array_combine($fields, $values));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update($tableName, $fields, $values, $id)
    {
        $sql = "UPDATE " . "$tableName" . " SET ";
        foreach (array_combine($fields, $values) as $field => $value) {
            $sql .= $field . "=? , ";
        }
        $sql .= "updated_at=NOW() WHERE id=?;";
        try {
            $stmt = $this->connection->prepare($sql);
            array_push($values, $id);
            $stmt->execute(array_values($values));
            //$stmt->execute(array_merge(array_filter(array_values($values)),[$id]));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function updateّField($tableName, $fields, $values, $attribute,$value)
    {
        $sql = "UPDATE " . "$tableName" . " SET ";
        foreach ($fields as $field) {
            $sql .= $field . "=? , ";
        }
        $sql .= "updated_at=NOW() WHERE $attribute=?;";
        try {
            $stmt = $this->connection->prepare($sql);
            array_push($values, $value);
            $stmt->execute(array_values($values));
            //$stmt->execute(array_merge(array_filter(array_values($values)),[$id]));
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function increament($tableName, $fields, $id)
    {
        $sql = "UPDATE " . "$tableName" . " SET ";
        foreach ($fields as $field) {
            $sql .= $field . "= $field + 1 , ";
        }
        $sql .= "updated_at=NOW() WHERE id=?;";
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($tableName, $id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM " . $tableName . " WHERE id=?;");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteField($tableName, $field,$value)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM " . $tableName . " WHERE ".$field."=?;");
            $stmt->execute([$value]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function executeQuery($sql, $values = null)
    {
        try {
            $stmt = $this->connection->prepare($sql);
            if ($values == null) {
                $stmt->execute();
            } else {
                $stmt->execute($values);
            }
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function createTable($sql)
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
