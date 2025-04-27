<?php

class EspecialidadRepository
{
    private $conn;

    // Constructor: Inicializar la conexión con la base de datos
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function obtenerTodas()
    {
        $sql = "SELECT * FROM especialidades WHERE estado != 'eliminada' ORDER BY nombre";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorAlias($alias)
    {
        try {
            $sql = "SELECT * FROM especialidades WHERE alias = :alias AND estado != 'eliminada'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }
    public function find($id)
    {
        try {
            $sql = "SELECT * FROM especialidades WHERE id_especialidad = :id AND estado != 'eliminada'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }

}
