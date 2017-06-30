<?php

class App
{
    private static $controller = null;
    private static $method = null;
    private static $args = [];
    private static $routes = [];
    private static $regxs = [
        ':num'  => '([0-9]+)',
        ':any'  => '([^/]+)',
        ':all'  => '(.*)'
    ];

    public static function __callStatic($method, $params)
    {
        foreach (static::$regxs as $regx => $val) {
            if (strpos($params[0], $regx) !== FALSE) {
                $params[0] = str_replace($regx, $val, $params[0]);
            }
        }
        array_push(static::$routes, [
            'method'    => strtoupper($method),
            'uri'       => $params[0],
            'action'    => $params[1]
        ]);
    }

    public static function dispatch()
    {
        $http_method = $_SERVER['REQUEST_METHOD'];
        $url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';

        $matches = array_filter(static::$routes, function($r) use ($url, $http_method) {
            return $r['uri'] === $url && $r['method'] === $http_method;
        });

        if (empty($matches)) {
            // we now know this must be a dynamic route
            $matches = array_filter(static::$routes, function($r) use ($url) {
                if (preg_match_all('#' . $r['uri'] . '$#', $url, $preg_results) && ! empty($r['uri'])) {
                    array_shift($preg_results);
                    static::$args = array_map(function($match) {
                        return $match[0];
                    }, $preg_results);
                    return true;
                }
                return false;
            });
        }

        if (empty($matches)) {
            echo "404 page not found";
            return http_response_code(404);
        }
        
        $match = array_shift($matches);

        if (is_string($match['action'])) {
            $segments = explode('@', $match['action']);
            static::$controller = new $segments[0]();

            if (method_exists(static::$controller, end($segments))) {
                static::$method = end($segments);
                return call_user_func_array([static::$controller, static::$method], static::$args);
            }
        }
        return call_user_func_array($match['action'], static::$args);
    }

}