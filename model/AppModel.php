<?php
class AppModel
{
    protected $db;

    function __construct()

    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
           
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
