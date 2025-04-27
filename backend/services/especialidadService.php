<?php

include_once __DIR__ . '/../repositories/especialidadRepository.php';

class EspecialidadService
{
    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }
    public function listarEspecialidades()
    {
        try {
            return $this->repository->obtenerTodas();
        } catch (Exception $e) {
            return [
                'error' => true,
                'mensaje' => 'No se pudieron obtener las especialidades.',
                'error_details' => [$e->getMessage()]
            ];
        }
    }
    public function obtenerEspecialidadByAlias($alias)
    {
        try {
            $especialidad = $this->repository->obtenerPorAlias($alias);

            if ($especialidad) {
                return $especialidad;
            } else {
                return [
                    'error' => true,
                    'mensaje' => 'No se pudo encontrar la especialidad ' . $alias,
                    'error_details' => ['La especiaidad no existe']
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => true,
                'mensaje' => 'No se pudo obtener la especialidad',
                'error_details' => [$e->getMessage()]
            ];
        }
    }
    public function obtenerEspecialidadById($id)
    {
        try {
            $especialidad = $this->repository->find($id);

            if ($especialidad) {
                return $especialidad;
            } else {
                return [
                    'error' => true,
                    'mensaje' => 'No se pudo obtener la especialidad',
                    'error_details' => ['La especiaidad no existe']
                ];
            }
        } catch (Exception $e) {

            return [
                'error' => true,
                'mensaje' => 'No se pudo obtener la especialidad',
                'error_details' => [$e->getMessage()]
            ];
        }
    }
}
