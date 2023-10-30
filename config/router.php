<?php
class Router {
    private $routes = [];

    public function get($route, $handler)
    {
        $this->routes['GET'][$route] = $handler;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            $handlerParts = explode('@', $handler);

            if (count($handlerParts) == 2) {
                $controllerName = $handlerParts[0];
                $action = $handlerParts[1];

                require_once "../app/controller/$controllerName.php";
                $controller = new $controllerName();
                $controller->$action();
            } else {
                echo "Controlador y acción no válidos.";
            }
        } else {
            echo "Ruta no encontrada.";
        }
    }
}

?>