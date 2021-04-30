<?php
namespace App\model;
abstract class Manager

{
    private $db;

    protected function dbConnect()

    {
        try {
            $this->db = new \PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
           
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        return $this->db;
    }
}
