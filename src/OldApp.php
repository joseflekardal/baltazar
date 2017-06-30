<?php

class App
{
    private $controller = null;
    private $method = null;
    private $args = [];
    private $routes = [];
    private $regxs = [
        ':num'  => '([0-9]+)',
        ':any'  => '([^/]+)',
        ':all'  => '(.*)'
    ];

    public function get($route, $action)
    {
        foreach ($this->regxs as $regx => $val) {
            if (strpos($route, $regx) !== FALSE) {
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
            if (strpos($route, $regx) !== FALSE) {
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
            if (strpos($route, $regx) !== FALSE) {
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

        $url = trim($_GET['url'], '/') ?? '';

        $matches = array_filter($this->routes, function($r) use ($url, $http_method) {
            return $r['uri'] === $url && $r['method'] === $http_method;
        });

        if (empty($matches)) {
            // we know must be a dynamic route
            $matches = array_filter($this->routes, function($r) use ($url) {
                if (preg_match_all('#' . $r['uri'] . '$#', $url, $preg_results) && ! empty($r['uri'])) {
                    array_shift($preg_results);
                    $this->args = array_map(function($match) {
                        return $match[0];
                    }, $preg_results);
                    return true;
                } else {
                    return false;
                }
            });
        }

        if (empty($matches)) {
            echo "404 page not found";
            return http_response_code(404);
        }
        
        $match = array_shift($matches);

        if (is_string($match['action'])) {
            $segments = explode('@', $match['action']);
            $this->controller = new $segments[0]();

            if (method_exists($this->controller, end($segments))) {
                $this->method = end($segments);
                return call_user_func_array([$this->controller, $this->method], $this->args);
            }
        }
        return call_user_func_array($match['action'], $this->args);
    }

}