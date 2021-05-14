<?php

namespace App\model;

abstract class Manager

{
    private static $db;

    private static function dbConnect()

    {
        try {
            self::$db = new \PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
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
