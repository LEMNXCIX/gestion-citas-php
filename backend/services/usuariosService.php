<?php

class UsuariosService
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function crearUsuario($nombre, $estado = 'activo')
    {
        if (empty($nombre)) {
            return [
                'error' => true,
                'mensaje' => 'El campo "nombre" es obligatorio.'
            ];
        }

        try {
            $usuario = $this->repository->insertarUsuario($nombre, $estado);
            return $usuario;
        } catch (Exception $e) {
            return [
                'error' => true,
                'mensaje' => 'No se pudo registrar el usuario.',
                'error_details' => [$e->getMessage()]
            ];
        }
    }

    public function obtenerUsuarioById($id)
    {
        try {
            $usuario = $this->repository->find($id);

            return $usuario;
        } catch (Exception $e) {
            return [
                'error' => true,
                'mensaje' => 'Ocurrio un problema al obtener el ususario',
                'error_details' => [
                    $e->getMessage()
                ]
            ];
        }
    }
}
