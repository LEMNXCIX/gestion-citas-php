<?php
require_once __DIR__ . '/../dependencias.php';
require_once __DIR__ . '/../controllers/CitasController.php';

function citasRoutes($router)
{
    global $contenedor;

    $controller = new CitasController($contenedor);
    header('Content-Type: application/json');

    $router->add("GET", "/api/citas", function () use ($controller) {
        header('Content-Type: application/json');
        $response = $controller->listarCitas();
        echo json_encode($response);
    });

    $router->add("POST", "/api/citas", function () use ($controller) {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $response = $controller->crearCita($input);
        echo json_encode($response);
    });

    $router->add("DELETE", "/api/citas/:id", function ($id) use ($controller) {
        header('Content-Type: application/json');
        $response = $controller->eliminarCita($id);
        echo json_encode($response);
    });
}
