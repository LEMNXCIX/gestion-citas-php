<?php
include_once __DIR__ . '/../services/especialidadService.php';
include_once __DIR__ . '/../repositories/especialidadRepository.php';
include_once __DIR__ . '/../connection.php';

class EspecialidadesController
{
    private $service;

    public function __construct()
    {
        $dbConnection = new DatabaseConnection();
        $conn = $dbConnection->getConnection();
        $repository = new EspecialidadRepository($conn);
        $this->service = new EspecialidadService($repository);
    }
    public function listarEspecialidades()
    {
        try {
            return $this->service->listarEspecialidades();
        } catch (Exception $e) {
            return [
                'error' => true,
                'success' => false,
                'mensaje' => 'Error al listar las especialidades.',
                'error_details' => [$e->getMessage()]
            ];
        }
    }
}
