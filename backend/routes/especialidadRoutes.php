<?php
include_once __DIR__ . '/../controllers/especialidadController.php';

function especialidadesRoutes($router)
{
    $controller = new EspecialidadesController();

    $router->add('GET', '/api/especialidades', function () use ($controller) {
        header('Content-Type: application/json');
        try {
            $especialidades = $controller->listarEspecialidades();
            http_response_code(200);
            echo json_encode($especialidades);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al listar especialidades']);
        }
    });
}