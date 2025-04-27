<?php
function viewsRoutes($router)
{
    $router->add("GET", "/", function () {
        setHtmlFile("frontend/registrar.html");
    });
    $router->add("GET", "/registrar", function () {
        setHtmlFile("frontend/registrar.html");
    });
    $router->add("GET", "/mostrar", function () {
        setHtmlFile("frontend/mostrar.html");
    });
}

function setHtmlFile($filePath)
{
    if (file_exists($filePath)) {
        header("Content-Type: text/html; charset=UTF-8");
        echo file_get_contents($filePath);
    } else {
        http_response_code(404);
        
        echo json_encode([
            "error" => true,
            "success" => false,
            "mensaje" => "Archivo no encontrado.",
            "error_detalis" => [
                "No se encontro el recurso"
            ]
        ]);
    }
}
