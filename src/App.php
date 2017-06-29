<?php

class App
{
    private $controller = null;
    private $method = null;
    private $args = [];
    private $routes = [];
    private $regxs = [
        ':num'  => '[0-9]+',
        ':any'  => '[^/]+',
        ':all'  =>  '.*'
    ];

    public function get($route, $action)
    {
        foreach ($this->regxs as $regx => $val) {
            if (strpos($route, $regx)) {
                $route = str_replace($regx, $val, $route);
            }
        }
        array_push($this->routes, [
            'method'    => 'GET',
            'uri'       => $route,
            'action'    => $action
        ]);
    }

    public function post($route, $action)
    {
        foreach ($this->regxs as $regx => $val) {
            if (strpos($route, $regx)) {
                $route = str_replace($regx, $val, $route);
            }
        }
        array_push($this->routes, [
            'method'    => 'POST',
            'uri'       => $route,
            'action'    => $action
        ]);
    }

    public function delete($route, $action)
    {
        foreach ($this->regxs as $regx => $val) {
            if (strpos($route, $regx)) {
                $route = str_replace($regx, $val, $route);
            }
        }
        array_push($this->routes, [
            'method'    => 'DELETE',
            'uri'       => $route,
            'action'    => $action
        ]);
    }

    public function dispatch()
    {
        $http_method = $_SERVER['REQUEST_METHOD'];

        $url = $_GET['url'] ?? '';

        foreach ($this->routes as $route) {
            if ($route['uri'] === $url) {
                if (is_string($route['action'])) {
                    $segments = explode('@', $route['action']);
                    $this->controller = new $segments[0]();

                    if (method_exists($this->controller, end($segments))) {
                        $this->method = end($segments);
                        return call_user_func_array([$this->controller, $this->method], $this->args);
                    }
                }
                return $route['action']();
            }

            if (preg_match_all('#' . $route['uri'] . '#', $url) && ! empty($route['uri'])) {
                $segments = explode('/', $url);
                $route_split = explode('/', $route['uri']);

                foreach ($this->regxs as $regx) {
                    $matches = array_keys($route_split, $regx);
                    foreach ($matches as $index) {
                        array_push($this->args, $segments[$index]);
                    }
                }

                if (is_string($route['action'])) {
                    $segments = explode('@', $route['action']);
                    $this->controller = new $segments[0]();

                    if (method_exists($this->controller, end($segments))) {
                        $this->method = end($segments);
                        return call_user_func_array([$this->controller, $this->method], $this->args);
                    }
                }

                return call_user_func_array($route['action'], $this->args);

            }
        }
        http_response_code(404);
        echo "404 page not found";
    }

}