<?php

use Lekardal\User;
use Lekardal\Post;

class App
{
    private static $routes = [];
    private static $regxs = [
        ':num'  => '[0-9]+',
        ':any'  => '[^/]+',
        ':all'  =>  '.*'
    ];

    public static function __callStatic($method, $params)
    {
        foreach(self::$regxs as $regx => $val) {
            if (strpos($params[0], $regx)) {
                $params[0] = str_replace($regx, $val, $params[0]);
            }
        }
        array_push(static::$routes, [
            'method'    => $method,
            'uri'       => $params[0],
            'action'    => $params[1]
        ]);
    }

    static function dispatch()
    {
        // CHECK HTTP METHOD!

        $url = $_GET['url'] ?? '';

        // none dynamic route
        foreach(self::$routes as $route) {
            if ($route['uri'] === $url) {
                return $route['action']();
            }
        }

        // dynamic route
        foreach(self::$routes as $route) {
            if (preg_match_all('#' . $route['uri'] . '#', $url) && ! empty($route['uri'])) {
                $segments = explode('/', $url);
                $route_split = explode('/', $route['uri']);

                $args = [];
                foreach (self::$regxs as $regx) {
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