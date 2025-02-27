<?php

namespace System\Database\DBBuilder;

use System\Config\Config;
use System\Database\DBConnection\DBConnection;

class DBBuilder
{
    public function __construct()
    {
        $this->createTables();
        die("migrations ran successflly");
    }

    private function getOldMigrations()
    {
        $data = file_get_contents(__DIR__ . '/oldTables.db');
        return empty($data) ? [] : unserialize($data);
    }

    private function putOldMigration($value)
    {
        file_put_contents(__DIR__ . '/oldTables.db', serialize($value));
    }

    private function getMigrations()
    {
        $oldMigrations = $this->getOldMigrations();

        $path = Config::get('app.BASE_DIR') . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;

        $allMigrations = glob($path . '*.php');

        $newMigrations = array_diff($allMigrations, $oldMigrations);

        $this->putOldMigration($allMigrations);
        $sqls = [];

        foreach ($newMigrations as $filename) {
            $sql = require $filename;
            if(!empty($sql[0])){
                array_push($sqls, $sql[0]);
            }

        }

        return $sqls;
    }

    private function createTables()
    {
        $migrations = $this->getMigrations();
        $pdo = DBConnection::getDBConnectionInstance();

        foreach ($migrations as $migration) {
            if(!empty($migration)){
                $statement = $pdo->prepare($migration);
                $statement->execute();
            }


        }
        return true;
    }
}
