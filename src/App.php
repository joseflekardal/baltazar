<?php

class App
{
    private $routes = [];
    private $regxs = [
        ':num'  => '[0-9]+',
        ':any'  => '[^/]+',
        ':all'  =>  '.*'
    ];

    public function get($route, $action)
    {
        foreach($this->regxs as $regx => $val) {
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

    public function dispatch()
    {
        // CHECK HTTP METHOD!

        $url = $_GET['url'] ?? '';

        // none dynamic route
        foreach($this->routes as $route) {
            if ($route['uri'] === $url) {
                return $route['action']();
            }
        }

        // dynamic route
        foreach($this->routes as $route) {
            if (preg_match_all('#' . $route['uri'] . '#', $url) && ! empty($route['uri'])) {
                $segments = explode('/', $url);
                $route_split = explode('/', $route['uri']);

                $args = [];
                foreach ($this->regxs as $regx) {
                    $matches = array_keys($route_split, $regx);
                    foreach($matches as $index) {
                        array_push($args, $segments[$index]);
                    }
                }

                if (is_string($route['action'])) {
                    $segments = explode('@', $route['action']);
                    $controller = new $segments[0]();
                    if (method_exists($controller, end($segments))) {
                        $method = end($segments);
                        return call_user_func_array([$controller, $method], $args);
                    }
                }
                return call_user_func_array($route['action'], $args);
            }
        }
        http_response_code(404);
        echo "404 page not found";
    }

}