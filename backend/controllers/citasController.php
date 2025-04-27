<?php
// include_once __DIR__ . '/../services/citasService.php';
// include_once __DIR__ . '/../repositories/citasRepository.php';
// include_once __DIR__ . '/../repositories/especialidadRepository.php';
// include_once __DIR__ . '/../connection.php';
include_once __DIR__ . '/../dependencias.php';

class CitasController
{
    private $service;

    public function __construct($contenedor)
    {
        $this->service = $contenedor->resolver('citasService');
    }

    public function listarCitas()
    {
        try {
            return $this->service->listarCitas();
        } catch (Exception $e) {
            return [
                'error' => true,
                'success' => false,
                'mensaje' => 'Error al listar las citas.',
                'error_details' => [$e->getMessage()]
            ];
        }
    }

    public function crearCita($datos)
    {
        try {
            if (empty($datos)) {
                return [
                    'error' => false,
                    'success' => false,
                    'mensaje' => 'Datos no validos.',
                    'error_details' => [
                        'No se obtuvieron datos',
                        'Los dartos se encuentran vacios'
                    ]
                ];
            }
            return $this->service->crearCita($datos);
        } catch (Exception $e) {
            return [
                'error' => true,
                'success' => false,
                'mensaje' => 'Error al crear la Cita.',
                'error_details' => [$e->getMessage()]
            ];
        }
    }

    public function eliminarCita($id)
    {
        try {
            return $this->service->eliminarCita($id);
        } catch (Exception $e) {
            return [
                'error' => true,
                'success' => false,
                'mensaje' => 'Error al eliminar la Cita.',
                'error_details' => [$e->getMessage()]
            ];
        }
    }
}
