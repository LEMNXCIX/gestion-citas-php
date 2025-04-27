<?php

class CitasRepository
{
    private $conn;

    // Constructor: Inicializar la conexión con la base de datos
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Obtener todas las citas
    public function obtenerTodas()
    {
        $sql = "SELECT * FROM citas WHERE estado != 'eliminada' ORDER BY creado_en DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insertar($usuario_id, $especialidad_id, $estado, $fecha_programada)
    {
        $sql = "INSERT INTO citas (usuario_id, especialidad_id, estado, fecha_hora_programacion, creado_en, actualizado_en) 
                VALUES (:usuario_id, :especialidad_id, :estado, :fecha_programada, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':especialidad_id', $especialidad_id, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_programada', $fecha_programada, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function eliminar($id_cita)
    {
        try {
            $sql = "UPDATE citas SET estado = 'eliminada', actualizado_en = CURRENT_TIMESTAMP  WHERE id_cita = :id_cita";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Throwable $th) {
            error_log($th->getMessage());
        }
    }
}
