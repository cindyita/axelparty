<?php

class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($pattern, $callback) {
        $this->addRoute('GET', $pattern, $callback);
    }

    public function post($pattern, $callback) {
        $this->addRoute('POST', $pattern, $callback);
    }

    private function addRoute($method, $pattern, $callback) {
        $pattern = trim($pattern, '/');
        $pattern = preg_replace('#\{([\w]+)\}#', '(?P<$1>[^/]+)', $pattern);
        $pattern = "#^$pattern$#";
        $this->routes[$method][$pattern] = $callback;
    }

    public function dispatch($method, $uri) {
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

        foreach ($this->routes[$method] as $pattern => $callback) {
            if (preg_match($pattern, $uri, $matches)) {
                // Extraer solo los parámetros nombrados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array($callback, $params);
            }
        }

        http_response_code(404);
        echo "404 - Página no encontrada";
    }
}
