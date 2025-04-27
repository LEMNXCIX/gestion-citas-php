<?php
class Router
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $this->routes[] = [
            "method" => strtoupper($method),
            "path" => $path,
            "callback" => $callback
        ];
    }

    public function run()
    {
        $requestedMethod = strtoupper($_SERVER["REQUEST_METHOD"]);
        $requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        foreach ($this->routes as $route) {
            
            if ($route["method"] === $requestedMethod) {
                // Buscar parametros
                $pattern = preg_replace('/:\w+/', '(\w+)', $route["path"]);
                if (preg_match('#^' . $pattern . '$#', $requestedPath, $matches)) {
                    // Extraer parametroa
                    array_shift($matches);
                    call_user_func_array($route["callback"], $matches);
                    return;
                }
            }
        }

        // Si no encuentra la ruta
        http_response_code(404);
        echo json_encode([
            "error" => true,
            "success" => false,
            "mensaje" => "Opps!! No deberias estar aqui",
            "error_detalis" => [
                "La ruta no se encuentra definida.",
            ]
        ]);
    }
}
