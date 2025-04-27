<?php
require_once 'router.php';
require_once "routes/citasRoutes.php";
require_once "routes/viewsRoutes.php";
require_once "routes/especialidadRoutes.php";
require_once __DIR__ . '/routes/especialidadRoutes.php';
$router = new Router();
$router->add("GET", "/styles.css", function () {
    if (file_exists("frontend/styles.css")) {
        header("Content-Type: text/css;");
        echo file_get_contents("frontend/styles.css");
    } else {
        http_response_code(404);
        echo "Archivo no encontrado.";
    }
});
//Rutas disponiblesssss
citasRoutes($router);
viewsRoutes($router);
especialidadesRoutes($router);      

$router->run();
