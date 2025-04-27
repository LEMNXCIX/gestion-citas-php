<?php

class DatabaseConnection
{
    private $conn;

    public function __construct($databaseFile = 'base_datos.sqlite')
    {
        try {
            $this->conn = new PDO("sqlite:" . $databaseFile);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar con la bd: " . $e->getMessage());
        }
    }
    public function getConnection()
    {
        return $this->conn;
    }
}