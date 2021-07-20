<?php

namespace App\model;

abstract class Manager

{
    private static $db;

    private static function dbConnect()
    
    {
        $ini = parse_ini_file('../../config.ini');
        $database = $ini['db_name'];
        $dbUser = $ini['db_user'];
        $dbPassword = $ini['db_password'];
        try {
            self::$db = new \PDO("mysql:host=localhost;dbname=$database;charset=utf8", $dbUser, $dbPassword);
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    protected function getDb()
    {
        if (self::$db == null) {
            self::dbConnect();
        }
        return self::$db;
    }
}
