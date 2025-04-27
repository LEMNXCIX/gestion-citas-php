<?php

class UsuariosRepository
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function insertarUsuario($nombre, $estado = 'activo')
    {
        $sql = "INSERT INTO usuarios (nombre, estado, creado_en, actualizado_en) 
                VALUES (:nombre, :estado, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $id_usuario = $this->conn->lastInsertId();

            return [
                'error' => false,
                'success' => true,
                'data' => [
                    'id_usuario' => $id_usuario,
                    'nombre' => $nombre,
                    'estado' => $estado
                ],
                'mensaje' => 'Usuario creado correctamente.'
            ];
        } else {
            return [
                'success' => false,
                'mensaje' => 'Error al crear el usuario.'
            ];
        }
    }

    public function find($id_usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE id_usuario= :id_usuario AND estado != 'eliminado'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
